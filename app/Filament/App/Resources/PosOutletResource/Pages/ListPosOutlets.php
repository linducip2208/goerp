<?php

namespace App\Filament\App\Resources\PosOutletResource\Pages;

use App\Filament\App\Resources\PosOutletResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPosOutlets extends ListRecords
{
    protected static string $resource = PosOutletResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
