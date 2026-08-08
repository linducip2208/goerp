<?php

namespace App\Filament\App\Resources\InventoryMovementResource\Pages;

use App\Filament\App\Resources\InventoryMovementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInventoryMovement extends EditRecord
{
    protected static string $resource = InventoryMovementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
