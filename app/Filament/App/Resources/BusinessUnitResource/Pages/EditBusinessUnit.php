<?php

namespace App\Filament\App\Resources\BusinessUnitResource\Pages;

use App\Filament\App\Resources\BusinessUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBusinessUnit extends EditRecord
{
    protected static string $resource = BusinessUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
