<?php

namespace App\Filament\Resources\SalesDeliveryResource\Pages;

use App\Filament\Resources\SalesDeliveryResource;
use App\Services\AuditService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSalesDelivery extends EditRecord
{
    protected static string $resource = SalesDeliveryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        AuditService::log(
            'update',
            'Penjualan',
            'SalesDelivery',
            $this->record->id,
            $this->record->delivery_no,
            $this->record->getOriginal(),
            $this->record->getChanges()
        );
    }
}
