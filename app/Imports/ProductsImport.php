<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductVariant;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;

class ProductsImport implements ToCollection, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading
{
    public array $importedIds = [];
    public array $skipped = [];
    public array $errors = [];
    public int $importedCount = 0;
    public int $skippedCount = 0;

    public function collection(Collection $rows)
    {
        $tenantId = auth()->user()->tenant_id;

        foreach ($rows as $row) {
            $row = $row->toArray();

            $product = Product::firstOrCreate(
                ['base_sku' => $row['sku'], 'tenant_id' => $tenantId],
                [
                    'tenant_id' => $tenantId,
                    'name' => $row['nama_produk'],
                    'brand' => $row['merek'] ?? null,
                    'unit' => $row['satuan'] ?? 'Pcs',
                    'purchase_price' => $row['harga_beli'] ?? 0,
                    'selling_price' => $row['harga_jual'] ?? 0,
                    'min_stock' => $row['stok_minimum'] ?? 0,
                    'is_active' => true,
                ]
            );

            ProductVariant::firstOrCreate(
                ['internal_sku' => $row['sku'], 'product_id' => $product->id],
                [
                    'name' => $row['nama_produk'],
                    'barcode' => $row['barcode'] ?? null,
                    'purchase_price' => $row['harga_beli'] ?? 0,
                    'selling_price' => $row['harga_jual'] ?? 0,
                    'min_stock' => $row['stok_minimum'] ?? 0,
                    'is_active' => true,
                ]
            );

            $this->importedIds[] = $product->id;
            $this->importedCount++;
        }
    }

    public function rules(): array
    {
        return [
            'sku' => 'required',
            'nama_produk' => 'required',
        ];
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
