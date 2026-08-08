<?php

namespace App\Filament\App\Widgets;

use App\Models\SalesInvoice;
use Filament\Facades\Filament;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class OverdueInvoices extends BaseWidget
{
    use DashboardWidgetFilter;

    protected static ?int $sort = 6;
    protected static ?string $heading = 'Faktur Jatuh Tempo';
    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'app' && static::isVisibleToRole(auth()->user()?->role);
    }

    protected static function isVisibleToRole(?string $role): bool
    {
        return in_array($role, ['finance', 'admin', 'owner']);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                SalesInvoice::whereIn('status', ['overdue', 'open'])
                    ->where('outstanding', '>', 0)
                    ->with('customer')
                    ->orderBy('due_date')
            )
            ->columns([
                TextColumn::make('invoice_no')->label('No. Faktur')->searchable(),
                TextColumn::make('customer.name')->label('Customer'),
                TextColumn::make('due_date')->label('Jatuh Tempo')->date('d M Y'),
                TextColumn::make('grand_total')->label('Total')->money('IDR'),
                TextColumn::make('outstanding')->label('Sisa')->money('IDR'),
                TextColumn::make('status')->label('Status')->badge()->color(fn(string $state): string => match ($state) {
                    'overdue' => 'danger',
                    'open' => 'warning',
                    default => 'gray',
                }),
            ]);
    }
}
