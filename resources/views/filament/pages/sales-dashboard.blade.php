<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="fi-wi-stats-overview-stat bg-white rounded-xl shadow-sm border border-stone-200 p-6">
            <div class="text-sm font-medium text-stone-500">Total Order</div>
            <div class="text-3xl font-bold text-stone-900 mt-1">{{ $this->getStats()['total_orders'] }}</div>
        </div>
        <div class="fi-wi-stats-overview-stat bg-white rounded-xl shadow-sm border border-stone-200 p-6">
            <div class="text-sm font-medium text-stone-500">Total Invoice</div>
            <div class="text-3xl font-bold text-stone-900 mt-1">{{ $this->getStats()['total_invoices'] }}</div>
        </div>
        <div class="fi-wi-stats-overview-stat bg-white rounded-xl shadow-sm border border-stone-200 p-6">
            <div class="text-sm font-medium text-stone-500">Total Pembayaran</div>
            <div class="text-3xl font-bold text-stone-900 mt-1">Rp {{ number_format($this->getStats()['total_payments'], 0, ',', '.') }}</div>
        </div>
        <div class="fi-wi-stats-overview-stat bg-white rounded-xl shadow-sm border border-stone-200 p-6">
            <div class="text-sm font-medium text-stone-500">Order Pending</div>
            <div class="text-3xl font-bold text-stone-900 mt-1">{{ $this->getStats()['pending_orders'] }}</div>
        </div>
    </div>
</x-filament-panels::page>
