<?php

namespace App\Filament\App\Resources\MarketplaceSkuMappingResource\Pages;

use App\Filament\App\Resources\MarketplaceSkuMappingResource;
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
