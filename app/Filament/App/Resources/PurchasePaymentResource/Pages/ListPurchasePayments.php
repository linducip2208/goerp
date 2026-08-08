<?php

namespace App\Filament\App\Resources\PurchasePaymentResource\Pages;

use App\Filament\App\Resources\PurchasePaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchasePayments extends ListRecords
{
    protected static string $resource = PurchasePaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
