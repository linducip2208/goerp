<?php

namespace App\Filament\App\Resources\InventoryBalanceResource\Pages;

use App\Filament\App\Resources\InventoryBalanceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInventoryBalance extends EditRecord
{
    protected static string $resource = InventoryBalanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
