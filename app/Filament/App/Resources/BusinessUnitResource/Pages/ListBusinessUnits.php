<?php

namespace App\Filament\App\Resources\BusinessUnitResource\Pages;

use App\Filament\App\Resources\BusinessUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBusinessUnits extends ListRecords
{
    protected static string $resource = BusinessUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
