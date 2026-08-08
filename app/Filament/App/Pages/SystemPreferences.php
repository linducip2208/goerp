<?php

namespace App\Filament\App\Pages;

use Filament\Pages\Page;

class SystemPreferences extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-adjustments-vertical';
    protected static ?string $navigationGroup = '⚙️ Settings';
    protected static ?int $navigationSort = 89;
    protected static ?string $title = 'Preferensi Sistem';

    protected static string $view = 'filament.pages.system-preferences';
}
