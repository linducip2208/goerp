<?php

namespace App\Filament\App\Resources\SalesLeadResource\Pages;

use App\Filament\App\Resources\SalesLeadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSalesLeads extends ListRecords
{
    protected static string $resource = SalesLeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
