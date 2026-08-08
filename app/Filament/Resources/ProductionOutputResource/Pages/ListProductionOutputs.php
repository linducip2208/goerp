<?php

namespace App\Filament\Resources\ProductionOutputResource\Pages;

use App\Filament\Resources\ProductionOutputResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductionOutputs extends ListRecords
{
    protected static string $resource = ProductionOutputResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
