<?php

namespace App\Filament\Pages;

use App\Models\InventoryBalance;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\Warehouse;
use Filament\Pages\Page;

class InventoryDashboard extends Page
{
    protected static ?string $navigationGroup = '🏠 Dashboard';
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?int $navigationSort = 5;
    protected static ?string $title = 'Dashboard Inventory';

    protected static string $view = 'filament.pages.inventory-dashboard';

    public function getStats(): array
    {
        return [
            'total_products' => Product::count(),
            'total_warehouses' => Warehouse::count(),
            'stock_movements' => InventoryMovement::count(),
            'stock_balances' => InventoryBalance::count(),
        ];
    }
}
