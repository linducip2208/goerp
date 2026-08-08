<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="fi-wi-stats-overview-stat bg-white rounded-xl shadow-sm border border-stone-200 p-6">
            <div class="text-sm font-medium text-stone-500">Total Produk</div>
            <div class="text-3xl font-bold text-stone-900 mt-1">{{ $this->getStats()['total_products'] }}</div>
        </div>
        <div class="fi-wi-stats-overview-stat bg-white rounded-xl shadow-sm border border-stone-200 p-6">
            <div class="text-sm font-medium text-stone-500">Total Gudang</div>
            <div class="text-3xl font-bold text-stone-900 mt-1">{{ $this->getStats()['total_warehouses'] }}</div>
        </div>
        <div class="fi-wi-stats-overview-stat bg-white rounded-xl shadow-sm border border-stone-200 p-6">
            <div class="text-sm font-medium text-stone-500">Pergerakan Stok</div>
            <div class="text-3xl font-bold text-stone-900 mt-1">{{ $this->getStats()['stock_movements'] }}</div>
        </div>
        <div class="fi-wi-stats-overview-stat bg-white rounded-xl shadow-sm border border-stone-200 p-6">
            <div class="text-sm font-medium text-stone-500">Saldo Stok</div>
            <div class="text-3xl font-bold text-stone-900 mt-1">{{ $this->getStats()['stock_balances'] }}</div>
        </div>
    </div>
</x-filament-panels::page>
