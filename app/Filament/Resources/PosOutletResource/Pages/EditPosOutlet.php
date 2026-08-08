<?php

namespace App\Filament\Resources\PosOutletResource\Pages;

use App\Filament\Resources\PosOutletResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPosOutlet extends EditRecord
{
    protected static string $resource = PosOutletResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
