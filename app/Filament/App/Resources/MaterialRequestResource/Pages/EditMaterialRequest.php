<?php

namespace App\Filament\App\Resources\MaterialRequestResource\Pages;

use App\Filament\App\Resources\MaterialRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMaterialRequest extends EditRecord
{
    protected static string $resource = MaterialRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
