<?php

namespace App\Filament\App\Resources\ProductVariantResource\Pages;

use App\Filament\App\Resources\ProductVariantResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductVariant extends EditRecord
{
    protected static string $resource = ProductVariantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
