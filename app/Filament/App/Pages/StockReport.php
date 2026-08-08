<?php

namespace App\Filament\App\Pages;

use App\Models\InventoryBalance;
use App\Models\Warehouse;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;

class StockReport extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';
    protected static ?string $navigationGroup = '📈 Reports';
    protected static ?int $navigationSort = 75;
    protected static ?string $title = 'Laporan Stok';

    protected static string $view = 'filament.pages.stock-report';

    public ?array $data = [];
    public array $balances = [];

    public function mount(): void
    {
        $this->form->fill([]);
        $this->calculate();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(4)
                    ->schema([
                        Select::make('warehouse_id')
                            ->label('Gudang')
                            ->options(Warehouse::where('tenant_id', auth()->user()->tenant_id)->pluck('name', 'id'))
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(fn() => $this->calculate()),
                    ]),
            ])
            ->statePath('data');
    }

    public function calculate(): void
    {
        $tenantId = auth()->user()->tenant_id;

        $query = InventoryBalance::query()
            ->where('tenant_id', $tenantId)
            ->with('productVariant.product', 'warehouse');

        if (!empty($this->data['warehouse_id'])) {
            $query->where('warehouse_id', $this->data['warehouse_id']);
        }

        $this->balances = $query->get()->toArray();
    }
}
