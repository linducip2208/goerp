<?php

namespace App\Filament\Resources\PieceRateResource\Pages;

use App\Filament\Resources\PieceRateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPieceRate extends EditRecord
{
    protected static string $resource = PieceRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
