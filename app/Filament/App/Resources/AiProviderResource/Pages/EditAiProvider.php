<?php

namespace App\Filament\App\Resources\AiProviderResource\Pages;

use App\Filament\App\Resources\AiProviderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAiProvider extends EditRecord
{
    protected static string $resource = AiProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
