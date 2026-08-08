<?php

namespace App\Filament\Resources\ProductionBomResource\Pages;

use App\Filament\Resources\ProductionBomResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductionBom extends EditRecord
{
    protected static string $resource = ProductionBomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
