<?php

namespace App\Filament\App\Resources\LockPeriodResource\Pages;

use App\Filament\App\Resources\LockPeriodResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLockPeriod extends EditRecord
{
    protected static string $resource = LockPeriodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
