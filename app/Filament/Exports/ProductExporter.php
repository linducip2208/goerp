<?php

namespace App\Filament\Exports;

use App\Models\Product;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ProductExporter extends Exporter
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('base_sku')->label('SKU'),
            ExportColumn::make('name')->label('Nama Produk'),
            ExportColumn::make('category.name')->label('Kategori'),
            ExportColumn::make('brand')->label('Merek'),
            ExportColumn::make('unit')->label('Satuan'),
            ExportColumn::make('purchase_price')->label('Harga Beli'),
            ExportColumn::make('selling_price')->label('Harga Jual'),
            ExportColumn::make('min_stock')->label('Stok Minimum'),
            ExportColumn::make('reorder_point')->label('Titik Pesan Ulang'),
            ExportColumn::make('description')->label('Deskripsi'),
            ExportColumn::make('is_active')->label('Aktif'),
            ExportColumn::make('created_at')->label('Dibuat'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        return 'Export produk selesai. ' . number_format($export->successful_rows) . ' baris berhasil diexport.';
    }
}
