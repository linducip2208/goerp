<?php

namespace App\Filament\App\Widgets;

trait DashboardWidgetFilter
{
    public static function canView(): bool
    {
        return static::isVisibleToRole(auth()->user()?->role);
    }

    protected static function isVisibleToRole(?string $role): bool
    {
        return true;
    }
}
