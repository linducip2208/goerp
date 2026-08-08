<?php

namespace App\Filament\Resources\PosOutletResource\Pages;

use App\Filament\Resources\PosOutletResource;
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
