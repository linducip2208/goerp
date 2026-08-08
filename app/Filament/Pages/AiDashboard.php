<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class AiDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationGroup = '🤖 AI';
    protected static ?int $navigationSort = 162;
    protected static ?string $title = 'AI Dashboard';

    protected static string $view = 'filament.pages.ai-dashboard';
}
