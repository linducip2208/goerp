<?php

namespace App\Filament\App\Resources\SalesPaymentResource\Pages;

use App\Filament\App\Resources\SalesPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSalesPayment extends EditRecord
{
    protected static string $resource = SalesPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
