<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="fi-wi-stats-overview-stat bg-white rounded-xl shadow-sm border border-stone-200 p-6">
            <div class="text-sm font-medium text-stone-500">Total Pendapatan</div>
            <div class="text-3xl font-bold text-stone-900 mt-1">Rp {{ number_format($this->getStats()['total_revenue'], 0, ',', '.') }}</div>
        </div>
        <div class="fi-wi-stats-overview-stat bg-white rounded-xl shadow-sm border border-stone-200 p-6">
            <div class="text-sm font-medium text-stone-500">Total Pengeluaran</div>
            <div class="text-3xl font-bold text-stone-900 mt-1">Rp {{ number_format($this->getStats()['total_expenses'], 0, ',', '.') }}</div>
        </div>
        <div class="fi-wi-stats-overview-stat bg-white rounded-xl shadow-sm border border-stone-200 p-6">
            <div class="text-sm font-medium text-stone-500">Jurnal Entry</div>
            <div class="text-3xl font-bold text-stone-900 mt-1">{{ $this->getStats()['journal_entries'] }}</div>
        </div>
        <div class="fi-wi-stats-overview-stat bg-white rounded-xl shadow-sm border border-stone-200 p-6">
            <div class="text-sm font-medium text-stone-500">Akun COA</div>
            <div class="text-3xl font-bold text-stone-900 mt-1">{{ $this->getStats()['accounts'] }}</div>
        </div>
    </div>
</x-filament-panels::page>
