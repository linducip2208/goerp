<?php

namespace App\Filament\Admin\Resources\SubscriptionInvoiceResource\Pages;

use App\Filament\Admin\Resources\SubscriptionInvoiceResource;
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
