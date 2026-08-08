<?php

namespace App\Filament\App\Resources\PurchasePaymentResource\Pages;

use App\Filament\App\Resources\PurchasePaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchasePayment extends EditRecord
{
    protected static string $resource = PurchasePaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
