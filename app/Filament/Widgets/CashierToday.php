<?php

namespace App\Filament\Widgets;

use App\Models\SalesPayment;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class CashierToday extends BaseWidget
{
    use DashboardWidgetFilter;

    protected static ?int $sort = 4;
    protected static ?string $heading = 'Pembayaran Hari Ini';
    protected int|string|array $columnSpan = 'full';

    protected static function isVisibleToRole(?string $role): bool
    {
        return in_array($role, ['cashier', 'admin', 'owner', 'finance']);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                SalesPayment::whereDate('payment_date', today())
                    ->with('invoice.customer')
                    ->latest('payment_date')
            )
            ->columns([
                TextColumn::make('payment_no')->label('No. Pembayaran')->searchable(),
                TextColumn::make('invoice.invoice_no')->label('No. Faktur')->searchable(),
                TextColumn::make('invoice.customer.name')->label('Customer'),
                TextColumn::make('amount')->label('Jumlah')->money('IDR'),
                TextColumn::make('method')->label('Metode')->badge(),
                TextColumn::make('payment_date')->label('Tanggal')->date('d M Y'),
            ]);
    }
}
