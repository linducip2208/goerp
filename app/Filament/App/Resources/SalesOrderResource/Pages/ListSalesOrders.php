<?php

namespace App\Filament\App\Resources\SalesOrderResource\Pages;

use App\Filament\App\Resources\SalesOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSalesOrders extends ListRecords
{
    protected static string $resource = SalesOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
