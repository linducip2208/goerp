<?php

namespace App\Filament\App\Pages;

use Filament\Pages\Page;

class AiDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationGroup = null;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?int $navigationSort = 999;
    protected static ?string $title = 'AI Dashboard';

    protected static string $view = 'filament.pages.ai-dashboard';
}