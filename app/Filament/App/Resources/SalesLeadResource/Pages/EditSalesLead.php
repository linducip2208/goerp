<?php

namespace App\Filament\App\Resources\SalesLeadResource\Pages;

use App\Filament\App\Resources\SalesLeadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSalesLead extends EditRecord
{
    protected static string $resource = SalesLeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
