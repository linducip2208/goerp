<?php

namespace App\Filament\App\Resources\ProductionOutputResource\Pages;

use App\Filament\App\Resources\ProductionOutputResource;
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
