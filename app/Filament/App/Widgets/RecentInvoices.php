<?php

namespace App\Filament\App\Widgets;

use App\Models\SalesInvoice;
use Filament\Facades\Filament;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentInvoices extends BaseWidget
{
    protected static ?int $sort = 3;
    protected static ?string $heading = 'Faktur Terbaru';
    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'app';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(SalesInvoice::latest()->take(10))
            ->columns([
                TextColumn::make('invoice_no')->label('No. Faktur')->searchable(),
                TextColumn::make('customer.name')->label('Customer'),
                TextColumn::make('invoice_date')->label('Tgl Faktur')->date('d M Y'),
                TextColumn::make('grand_total')->label('Total')->money('IDR'),
                TextColumn::make('status')->label('Status')->badge()->color(fn(string $state): string => match ($state) {
                    'draft' => 'gray', 'open' => 'warning', 'partial' => 'info',
                    'paid' => 'success', 'overdue' => 'danger', 'void' => 'gray',
                    default => 'gray',
                }),
            ]);
    }
}
