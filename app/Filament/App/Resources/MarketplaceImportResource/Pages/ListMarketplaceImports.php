<?php

namespace App\Filament\App\Resources\MarketplaceImportResource\Pages;

use App\Filament\App\Resources\MarketplaceImportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMarketplaceImports extends ListRecords
{
    protected static string $resource = MarketplaceImportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
