<?php

namespace App\Filament\Resources\MarketplaceSkuMappingResource\Pages;

use App\Filament\Resources\MarketplaceSkuMappingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMarketplaceSkuMappings extends ListRecords
{
    protected static string $resource = MarketplaceSkuMappingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
