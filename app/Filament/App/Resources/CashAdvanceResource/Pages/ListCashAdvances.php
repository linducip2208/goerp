<?php

namespace App\Filament\App\Resources\CashAdvanceResource\Pages;

use App\Filament\App\Resources\CashAdvanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCashAdvances extends ListRecords
{
    protected static string $resource = CashAdvanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
