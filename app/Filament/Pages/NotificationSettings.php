<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class NotificationSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-bell-alert';
    protected static ?string $navigationGroup = '🔔 Notifikasi';
    protected static ?int $navigationSort = 171;
    protected static ?string $title = 'Pengaturan Notifikasi';

    protected static string $view = 'filament.pages.notification-settings';
}
