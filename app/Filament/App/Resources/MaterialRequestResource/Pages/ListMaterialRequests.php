<?php

namespace App\Filament\App\Resources\MaterialRequestResource\Pages;

use App\Filament\App\Resources\MaterialRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMaterialRequests extends ListRecords
{
    protected static string $resource = MaterialRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
