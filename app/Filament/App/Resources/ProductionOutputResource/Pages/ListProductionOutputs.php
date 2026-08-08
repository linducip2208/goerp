<?php

namespace App\Filament\App\Resources\ProductionOutputResource\Pages;

use App\Filament\App\Resources\ProductionOutputResource;
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
