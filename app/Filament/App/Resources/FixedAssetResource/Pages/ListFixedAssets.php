<?php

namespace App\Filament\App\Resources\FixedAssetResource\Pages;

use App\Filament\App\Resources\FixedAssetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFixedAssets extends ListRecords
{
    protected static string $resource = FixedAssetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
