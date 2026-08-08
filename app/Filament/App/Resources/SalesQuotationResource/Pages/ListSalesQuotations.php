<?php

namespace App\Filament\App\Resources\SalesQuotationResource\Pages;

use App\Filament\App\Resources\SalesQuotationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSalesQuotations extends ListRecords
{
    protected static string $resource = SalesQuotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
