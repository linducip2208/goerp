<?php

namespace App\Filament\App\Resources\IntegrationResource\Pages;

use App\Filament\App\Resources\IntegrationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIntegration extends EditRecord
{
    protected static string $resource = IntegrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
