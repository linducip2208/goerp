<?php

namespace App\Filament\App\Resources\ProductResource\Pages;

use App\Filament\App\Resources\ProductResource;
use App\Filament\Exports\ProductExporter;
use App\Filament\Imports\ProductImporter;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ImportAction::make()
                ->importer(ProductImporter::class)
                ->color('gray'),
            Actions\ExportAction::make()
                ->exporter(ProductExporter::class)
                ->color('gray'),
            Actions\CreateAction::make()
                ->label('Tambah Produk'),
        ];
    }
}
