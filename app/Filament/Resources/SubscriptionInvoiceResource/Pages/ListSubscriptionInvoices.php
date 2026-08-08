<?php

namespace App\Filament\Resources\SubscriptionInvoiceResource\Pages;

use App\Filament\Resources\SubscriptionInvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubscriptionInvoices extends ListRecords
{
    protected static string $resource = SubscriptionInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
