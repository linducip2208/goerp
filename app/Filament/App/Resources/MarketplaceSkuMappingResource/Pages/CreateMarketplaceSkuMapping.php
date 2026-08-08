<?php

namespace App\Filament\App\Resources\MarketplaceSkuMappingResource\Pages;

use App\Filament\App\Resources\MarketplaceSkuMappingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMarketplaceSkuMapping extends CreateRecord
{
    protected static string $resource = MarketplaceSkuMappingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['tenant_id'] = auth()->user()->tenant_id;

        return $data;
    }
}
