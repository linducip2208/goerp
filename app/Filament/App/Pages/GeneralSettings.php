<?php

namespace App\Filament\App\Pages;

use Filament\Pages\Page;

class GeneralSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationGroup = '⚙️ Pengaturan';
    protected static ?int $navigationSort = 82;
    protected static ?string $title = 'Pengaturan Umum';

    protected static string $view = 'filament.pages.general-settings';
}
