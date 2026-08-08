<?php

namespace App\Filament\App\Resources\PurchaseReturnResource\Pages;

use App\Filament\App\Resources\PurchaseReturnResource;
use App\Services\AuditService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseReturn extends EditRecord
{
    protected static string $resource = PurchaseReturnResource::class;

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
            'Pembelian',
            'PurchaseReturn',
            $this->record->id,
            $this->record->return_no,
            $this->record->getOriginal(),
            $this->record->getChanges()
        );
    }
}
