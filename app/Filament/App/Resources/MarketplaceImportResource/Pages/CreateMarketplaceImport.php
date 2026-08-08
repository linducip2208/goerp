<?php

namespace App\Filament\App\Resources\MarketplaceImportResource\Pages;

use App\Filament\App\Resources\MarketplaceImportResource;
use App\Models\MarketplaceImport;
use App\Models\MarketplaceOrder;
use App\Models\MarketplaceOrderItem;
use App\Services\Marketplace\MarketplaceImportService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateMarketplaceImport extends CreateRecord
{
    protected static string $resource = MarketplaceImportResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['tenant_id'] = auth()->user()->tenant_id;
        $data['company_id'] = auth()->user()->company_id;
        $data['status'] = 'uploaded';

        if (isset($data['file'])) {
            $data['filename'] = $data['file'] instanceof \Illuminate\Http\UploadedFile
                ? $data['file']->getClientOriginalName()
                : basename($data['file']);
        }

        unset($data['file']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $filePath = null;

        if (isset($this->data['file'])) {
            $file = $this->data['file'];
            $filePath = $file instanceof \Illuminate\Http\UploadedFile
                ? Storage::disk('public')->path('marketplace-imports/' . $file->hashName())
                : Storage::disk('public')->path($file);

            if (!file_exists($filePath)) {
                $filePath = $file instanceof \Illuminate\Http\UploadedFile
                    ? $file->getRealPath()
                    : null;
            }

            if ($filePath && file_exists($filePath)) {
                $service = app(MarketplaceImportService::class);
                $uploadedFile = new \Illuminate\Http\UploadedFile(
                    $filePath,
                    $this->record->filename,
                    null,
                    null,
                    true
                );

                $orders = $service->parseExcel($uploadedFile);

                $totalItems = 0;
                foreach ($orders as $orderData) {
                    $itemId = $orderData['marketplace_item_id'] ?? null;
                    $orderDate = $orderData['order_date'] ?? now()->format('Y-m-d');

                    if (is_array($orderDate)) {
                        $orderDate = now()->format('Y-m-d');
                    }

                    $order = MarketplaceOrder::create([
                        'import_id' => $this->record->id,
                        'order_no' => $orderData['order_no'] ?? '',
                        'order_date' => $orderDate,
                        'order_status' => $orderData['order_status'] ?? null,
                        'marketplace_item_id' => $itemId ?: '',
                    ]);

                    foreach ($orderData['items'] as $itemData) {
                        MarketplaceOrderItem::create([
                            'order_id' => $order->id,
                            'marketplace_sku' => $itemData['marketplace_sku'] ?? '',
                            'product_name' => $itemData['product_name'] ?? 'Unknown',
                            'variant' => $itemData['variant'] ?? null,
                            'quantity' => $itemData['quantity'] ?? 0,
                            'price' => $itemData['price'] ?? 0,
                            'discount' => $itemData['discount'] ?? 0,
                            'total' => $itemData['total'] ?? 0,
                            'match_status' => 'unmatched',
                        ]);
                        $totalItems++;
                    }
                }

                $this->record->update([
                    'total_orders' => count($orders),
                    'total_items' => $totalItems,
                ]);
            }
        }
    }
}
