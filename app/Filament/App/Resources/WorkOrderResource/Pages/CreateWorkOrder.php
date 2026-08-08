<?php

namespace App\Filament\App\Resources\WorkOrderResource\Pages;

use App\Filament\App\Resources\WorkOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWorkOrder extends CreateRecord
{
    protected static string $resource = WorkOrderResource::class;
}
