<?php

namespace App\Filament\App\Resources\SalesInvoiceResource\Pages;

use App\Filament\App\Resources\SalesInvoiceResource;
use App\Services\AuditService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSalesInvoice extends EditRecord
{
    protected static string $resource = SalesInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('downloadPdf')
                ->label('Download PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->url(fn() => route('invoice.pdf', $this->record))
                ->openUrlInNewTab()
                ->color('success'),
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        AuditService::log(
            'update',
            'Sales',
            'SalesInvoice',
            $this->record->id,
            $this->record->invoice_no,
            $this->record->getOriginal(),
            $this->record->getChanges()
        );
    }
}
