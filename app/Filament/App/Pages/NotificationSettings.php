<?php

namespace App\Filament\App\Pages;

use Filament\Pages\Page;

class NotificationSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-bell-alert';
    protected static ?string $navigationGroup = '⚙️ Pengaturan';
    protected static ?int $navigationSort = 165;
    protected static ?string $title = 'Pengaturan Notifikasi';

    protected static string $view = 'filament.pages.notification-settings';
}
