<?php

namespace App\Filament\App\Resources\SalesQuotationResource\Pages;

use App\Filament\App\Resources\SalesQuotationResource;
use App\Services\AuditService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSalesQuotation extends EditRecord
{
    protected static string $resource = SalesQuotationResource::class;

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
            'SalesQuotation',
            $this->record->id,
            $this->record->quotation_no,
            $this->record->getOriginal(),
            $this->record->getChanges()
        );
    }
}
