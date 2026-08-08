<?php

namespace App\Filament\App\Resources\PosOutletResource\Pages;

use App\Filament\App\Resources\PosOutletResource;
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
