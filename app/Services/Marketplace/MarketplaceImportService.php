<?php

namespace App\Services\Marketplace;

use App\Models\MarketplaceImport;
use App\Models\MarketplaceOrder;
use App\Models\MarketplaceOrderItem;
use App\Models\MarketplaceSkuMapping;
use App\Models\ProductVariant;
use App\Models\SalesInvoice;
use App\Models\SalesInvoiceItem;
use App\Models\InventoryMovement;
use Illuminate\Http\UploadedFile;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MarketplaceImportService
{
    public function parseExcel(UploadedFile $file): array
    {
        $spreadsheet = IOFactory::load($file->getRealPath());
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        if (empty($rows) || count($rows) < 2) {
            return [];
        }

        $headers = array_map('strtolower', array_map('trim', $rows[0]));
        $colMap = [];
        foreach ($headers as $index => $header) {
            $colMap[$header] = $index;
        }

        $orders = [];
        $currentOrderNo = null;

        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            if (empty(array_filter($row))) {
                continue;
            }

            $orderNo = $this->getCol($row, $colMap, ['order_no', 'order id', 'no pesanan', 'nomor pesanan', 'order number']);
            $marketplaceItemId = $this->getCol($row, $colMap, ['marketplace_item_id', 'item id', 'order item id', 'id item']);
            $sku = $this->getCol($row, $colMap, ['sku', 'marketplace_sku', 'kode sku', 'seller sku']);
            $productName = $this->getCol($row, $colMap, ['product_name', 'nama produk', 'product', 'nama barang', 'item name']);
            $variant = $this->getCol($row, $colMap, ['variant', 'variasi', 'variation']);
            $qty = floatval($this->getCol($row, $colMap, ['quantity', 'qty', 'jumlah']));
            $price = floatval($this->getCol($row, $colMap, ['price', 'harga', 'unit price', 'harga satuan']));
            $discount = floatval($this->getCol($row, $colMap, ['discount', 'diskon', 'discount amount']));
            $total = floatval($this->getCol($row, $colMap, ['total', 'total price', 'total harga']));
            $orderDate = $this->getCol($row, $colMap, ['order_date', 'tanggal pesanan', 'order date', 'tgl pesanan']);
            $orderStatus = $this->getCol($row, $colMap, ['order_status', 'status pesanan', 'status']);

            if (empty($orderNo)) {
                continue;
            }

            if (!isset($orders[$orderNo])) {
                $orders[$orderNo] = [
                    'order_no' => $orderNo,
                    'order_date' => $orderDate ?: now()->format('Y-m-d'),
                    'order_status' => $orderStatus ?: 'pending',
                    'marketplace_item_id' => $marketplaceItemId,
                    'items' => [],
                ];
            }

            $orders[$orderNo]['items'][] = [
                'marketplace_sku' => $sku ?: '',
                'product_name' => $productName ?: 'Unknown Product',
                'variant' => $variant,
                'quantity' => $qty,
                'price' => $price,
                'discount' => $discount,
                'total' => $total ?: ($price * $qty - $discount),
            ];
        }

        return array_values($orders);
    }

    private function getCol(array $row, array $colMap, array $possibleKeys): ?string
    {
        foreach ($possibleKeys as $key) {
            if (isset($colMap[$key]) && isset($row[$colMap[$key]])) {
                $val = trim((string) $row[$colMap[$key]]);
                if ($val !== '') {
                    return $val;
                }
            }
        }
        return null;
    }

    public function matchSku(array $orderItems, string $marketplace): array
    {
        $matched = 0;
        $unmatched = 0;
        $tenantId = auth()->user()?->tenant_id;

        foreach ($orderItems as &$item) {
            if (empty($item['marketplace_sku'])) {
                $item['match_status'] = 'unmatched';
                $item['internal_sku_id'] = null;
                $unmatched++;
                continue;
            }

            $mapping = MarketplaceSkuMapping::query()
                ->where('tenant_id', $tenantId)
                ->where('marketplace', $marketplace)
                ->where('marketplace_sku', $item['marketplace_sku'])
                ->first();

            if ($mapping) {
                $item['match_status'] = 'matched';
                $item['internal_sku_id'] = $mapping->product_variant_id;
                $matched++;
                continue;
            }

            $variant = ProductVariant::query()
                ->whereHas('product', function ($q) use ($tenantId) {
                    $q->where('tenant_id', $tenantId);
                })
                ->where('internal_sku', $item['marketplace_sku'])
                ->first();

            if ($variant) {
                $item['match_status'] = 'matched';
                $item['internal_sku_id'] = $variant->id;
                $matched++;
            } else {
                $item['match_status'] = 'unmatched';
                $item['internal_sku_id'] = null;
                $unmatched++;
            }
        }

        return [$orderItems, $matched, $unmatched];
    }

    public function deduplicate(array $orders, int $importId): array
    {
        $existingIds = MarketplaceOrder::query()
            ->where('import_id', $importId)
            ->pluck('marketplace_item_id')
            ->toArray();

        $duplicates = 0;
        $filtered = [];

        foreach ($orders as $order) {
            $itemId = $order['marketplace_item_id'];
            if ($itemId && (in_array($itemId, $existingIds) || in_array($itemId, $filtered))) {
                $duplicates++;
                continue;
            }
            if ($itemId) {
                $filtered[] = $itemId;
            }
            $filtered[] = $order;
        }

        return [$filtered, $duplicates];
    }

    public function importOrders(array $orders, int $warehouseId, int $importId): array
    {
        $imported = 0;
        $tenantId = auth()->user()?->tenant_id;
        $companyId = auth()->user()?->company_id;
        $errors = [];

        foreach ($orders as $orderData) {
            $marketplaceOrder = MarketplaceOrder::query()
                ->where('import_id', $importId)
                ->where('order_no', $orderData['order_no'] ?? '')
                ->first();

            if (!$marketplaceOrder) {
                continue;
            }

            $items = MarketplaceOrderItem::query()
                ->where('order_id', $marketplaceOrder->id)
                ->where('match_status', 'matched')
                ->whereNotNull('internal_sku_id')
                ->get();

            if ($items->isEmpty()) {
                continue;
            }

            try {
                $subtotal = 0;
                $discountTotal = 0;

                foreach ($items as $item) {
                    $lineTotal = floatval($item->total);
                    $subtotal += $lineTotal;
                    $discountTotal += floatval($item->discount ?? 0);
                }

                $salesInvoice = SalesInvoice::create([
                    'tenant_id' => $tenantId,
                    'company_id' => $companyId,
                    'customer_id' => null,
                    'invoice_no' => 'MKT-' . $orderData['order_no'],
                    'invoice_date' => $orderData['order_date'] ?? now()->format('Y-m-d'),
                    'due_date' => now()->addDays(30)->format('Y-m-d'),
                    'warehouse_id' => $warehouseId,
                    'channel' => 'marketplace',
                    'currency' => 'IDR',
                    'status' => 'draft',
                    'subtotal' => $subtotal,
                    'discount_total' => $discountTotal,
                    'tax_total' => 0,
                    'grand_total' => $subtotal - $discountTotal,
                    'paid_amount' => 0,
                    'outstanding' => $subtotal - $discountTotal,
                ]);

                foreach ($items as $item) {
                    $lineTotal = floatval($item->total);
                    SalesInvoiceItem::create([
                        'invoice_id' => $salesInvoice->id,
                        'product_variant_id' => $item->internal_sku_id,
                        'description' => $item->product_name,
                        'quantity' => floatval($item->quantity),
                        'unit_price' => floatval($item->price),
                        'discount_amount' => floatval($item->discount ?? 0),
                        'discount_percent' => 0,
                        'tax_percent' => 0,
                        'tax_amount' => 0,
                        'subtotal' => $lineTotal,
                        'total' => $lineTotal - floatval($item->discount ?? 0),
                    ]);

                    InventoryMovement::create([
                        'tenant_id' => $tenantId,
                        'product_variant_id' => $item->internal_sku_id,
                        'warehouse_id' => $warehouseId,
                        'movement_type' => 'out',
                        'movement_date' => now()->format('Y-m-d'),
                        'quantity' => floatval($item->quantity),
                        'reference' => 'MKT-' . $orderData['order_no'],
                        'source_type' => 'marketplace',
                        'source_id' => $salesInvoice->id,
                        'cost_price' => floatval($item->price),
                    ]);
                }

                $imported++;
            } catch (\Exception $e) {
                $errors[] = 'Order ' . ($orderData['order_no'] ?? 'Unknown') . ': ' . $e->getMessage();
            }
        }

        return [$imported, $errors];
    }

    public function getImportPreview(int $importId): array
    {
        $import = MarketplaceImport::with('orders.items')->findOrFail($importId);

        $summary = [
            'import' => $import,
            'total_orders' => $import->orders->count(),
            'total_items' => $import->orders->sum(fn($o) => $o->items->count()),
            'matched_count' => $import->orders->sum(fn($o) => $o->items->where('match_status', 'matched')->count()),
            'unmatched_count' => $import->orders->sum(fn($o) => $o->items->where('match_status', 'unmatched')->count()),
            'unmatched_items' => [],
        ];

        foreach ($import->orders as $order) {
            foreach ($order->items as $item) {
                if ($item->match_status === 'unmatched') {
                    $summary['unmatched_items'][] = [
                        'order_no' => $order->order_no,
                        'marketplace_sku' => $item->marketplace_sku,
                        'product_name' => $item->product_name,
                        'variant' => $item->variant,
                        'quantity' => $item->quantity,
                        'total' => $item->total,
                    ];
                }
            }
        }

        return $summary;
    }
}
