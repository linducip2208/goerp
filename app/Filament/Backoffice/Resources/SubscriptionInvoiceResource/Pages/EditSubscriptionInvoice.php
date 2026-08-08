<?php

namespace App\Filament\Backoffice\Resources\SubscriptionInvoiceResource\Pages;

use App\Filament\Backoffice\Resources\SubscriptionInvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubscriptionInvoice extends EditRecord
{
    protected static string $resource = SubscriptionInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
