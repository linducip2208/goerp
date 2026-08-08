<?php

namespace App\Filament\App\Resources\ApiKeyResource\Pages;

use App\Filament\App\Resources\ApiKeyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateApiKey extends CreateRecord
{
    protected static string $resource = ApiKeyResource::class;
}
