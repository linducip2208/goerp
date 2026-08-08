<?php

namespace App\Filament\Widgets;

use App\Models\Tenant;
use Filament\Facades\Filament;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class NewTenantsWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected static ?string $heading = 'Tenant Terbaru';
    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'admin';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Tenant::latest()->take(10))
            ->columns([
                TextColumn::make('name')->label('Nama Tenant')->searchable(),
                TextColumn::make('domain')->label('Domain'),
                TextColumn::make('status')->label('Status')->badge()->color(fn(string $state): string => match($state) {
                    'active' => 'success',
                    'trial' => 'info',
                    'expired' => 'warning',
                    'suspended' => 'danger',
                    default => 'gray',
                }),
                TextColumn::make('created_at')->label('Terdaftar')->dateTime('d M Y'),
            ]);
    }
}
