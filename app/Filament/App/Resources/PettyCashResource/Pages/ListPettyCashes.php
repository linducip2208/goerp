<?php

namespace App\Filament\App\Resources\PettyCashResource\Pages;

use App\Filament\App\Resources\PettyCashResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPettyCashes extends ListRecords
{
    protected static string $resource = PettyCashResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
