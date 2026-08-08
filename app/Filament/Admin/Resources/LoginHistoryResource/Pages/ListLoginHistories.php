<?php

namespace App\Filament\Admin\Resources\LoginHistoryResource\Pages;

use App\Filament\Admin\Resources\LoginHistoryResource;
use Filament\Resources\Pages\ListRecords;

class ListLoginHistories extends ListRecords
{
    protected static string $resource = LoginHistoryResource::class;
}
