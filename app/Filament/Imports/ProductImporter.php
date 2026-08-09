<?php

namespace App\Filament\Imports;

use App\Models\Product;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ProductImporter extends Importer
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')->requiredMapping()->label('Nama Produk'),
            ImportColumn::make('base_sku')->requiredMapping()->label('SKU'),
            ImportColumn::make('brand')->label('Merek'),
            ImportColumn::make('unit')->label('Satuan'),
            ImportColumn::make('purchase_price')->numeric()->label('Harga Beli'),
            ImportColumn::make('selling_price')->numeric()->label('Harga Jual'),
            ImportColumn::make('min_stock')->numeric()->label('Stok Minimum'),
            ImportColumn::make('reorder_point')->numeric()->label('Titik Pesan Ulang'),
            ImportColumn::make('description')->label('Deskripsi'),
            ImportColumn::make('tax_purchase')->label('Pajak Beli'),
            ImportColumn::make('tax_sales')->label('Pajak Jual'),
        ];
    }

    public function resolveRecord(): ?Product
    {
        return Product::firstOrNew([
            'base_sku' => $this->data['base_sku'],
            'tenant_id' => filament()->getTenant()?->id,
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Import produk selesai. ' . number_format($import->successful_rows) . ' baris berhasil diimport.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' baris gagal.';
        }

        return $body;
    }
}
