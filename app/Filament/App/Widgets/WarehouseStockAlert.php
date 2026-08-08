<?php

namespace App\Filament\App\Widgets;

use App\Models\Product;
use App\Models\InventoryBalance;
use Filament\Facades\Filament;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class WarehouseStockAlert extends BaseWidget
{
    use DashboardWidgetFilter;

    protected static ?int $sort = 5;
    protected static ?string $heading = 'Stok Di Bawah Minimum';
    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'app' && static::isVisibleToRole(auth()->user()?->role);
    }

    protected static function isVisibleToRole(?string $role): bool
    {
        return in_array($role, ['warehouse', 'admin', 'owner']);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::whereColumn('min_stock', '>', \DB::raw('COALESCE((SELECT SUM(ib.available) FROM inventory_balances ib JOIN product_variants pv ON pv.id = ib.product_variant_id WHERE pv.product_id = products.id), 0)'))
                    ->where('is_active', true)
                    ->orderBy('min_stock')
            )
            ->columns([
                TextColumn::make('name')->label('Produk')->searchable(),
                TextColumn::make('base_sku')->label('SKU')->searchable(),
                TextColumn::make('min_stock')->label('Min. Stok')->alignRight(),
                TextColumn::make('category.name')->label('Kategori'),
                TextColumn::make('unit')->label('Unit'),
            ]);
    }
}
