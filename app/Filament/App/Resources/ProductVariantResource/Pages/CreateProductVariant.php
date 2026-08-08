<?php

namespace App\Filament\App\Resources\ProductVariantResource\Pages;

use App\Filament\App\Resources\ProductVariantResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProductVariant extends CreateRecord
{
    protected static string $resource = ProductVariantResource::class;
}
