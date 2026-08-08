<?php

namespace App\Filament\App\Resources\BlogCategoryResource\Pages;

use App\Filament\App\Resources\BlogCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBlogCategory extends CreateRecord
{
    protected static string $resource = BlogCategoryResource::class;
}
