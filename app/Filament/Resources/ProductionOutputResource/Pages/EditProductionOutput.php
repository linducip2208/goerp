<?php

namespace App\Filament\Resources\ProductionOutputResource\Pages;

use App\Filament\Resources\ProductionOutputResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductionOutput extends EditRecord
{
    protected static string $resource = ProductionOutputResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
