<?php

namespace App\Filament\App\Resources\ProductionBomResource\Pages;

use App\Filament\App\Resources\ProductionBomResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductionBoms extends ListRecords
{
    protected static string $resource = ProductionBomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
