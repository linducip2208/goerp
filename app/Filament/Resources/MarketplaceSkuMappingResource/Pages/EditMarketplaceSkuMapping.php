<?php

namespace App\Filament\Resources\MarketplaceSkuMappingResource\Pages;

use App\Filament\Resources\MarketplaceSkuMappingResource;
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
