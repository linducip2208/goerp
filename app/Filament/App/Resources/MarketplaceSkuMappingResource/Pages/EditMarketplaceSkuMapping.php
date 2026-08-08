<?php

namespace App\Filament\App\Resources\MarketplaceSkuMappingResource\Pages;

use App\Filament\App\Resources\MarketplaceSkuMappingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMarketplaceSkuMapping extends EditRecord
{
    protected static string $resource = MarketplaceSkuMappingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
