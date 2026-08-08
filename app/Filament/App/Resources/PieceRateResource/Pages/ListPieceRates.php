<?php

namespace App\Filament\App\Resources\PieceRateResource\Pages;

use App\Filament\App\Resources\PieceRateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPieceRates extends ListRecords
{
    protected static string $resource = PieceRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
