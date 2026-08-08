<?php

namespace App\Filament\App\Resources\SalesInvoiceResource\Pages;

use App\Filament\App\Resources\SalesInvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSalesInvoices extends ListRecords
{
    protected static string $resource = SalesInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
