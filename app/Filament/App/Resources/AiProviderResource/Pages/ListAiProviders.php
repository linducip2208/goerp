<?php

namespace App\Filament\App\Resources\AiProviderResource\Pages;

use App\Filament\App\Resources\AiProviderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAiProviders extends ListRecords
{
    protected static string $resource = AiProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
