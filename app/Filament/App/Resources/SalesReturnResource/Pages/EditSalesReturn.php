<?php

namespace App\Filament\App\Resources\SalesReturnResource\Pages;

use App\Filament\App\Resources\SalesReturnResource;
use App\Services\AuditService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSalesReturn extends EditRecord
{
    protected static string $resource = SalesReturnResource::class;

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
            'SalesReturn',
            $this->record->id,
            $this->record->return_no,
            $this->record->getOriginal(),
            $this->record->getChanges()
        );
    }
}
