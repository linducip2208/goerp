<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="rounded-xl p-4 text-white text-center" style="background:{{ $agingData['current']['color'] }}">
            <div class="text-2xl font-bold">Rp {{ number_format($agingData['current']['total'], 0, ',', '.') }}</div>
            <div class="text-sm mt-1 opacity-80">{{ $agingData['current']['label'] }}</div>
            <div class="text-xs opacity-60">{{ $agingData['current']['count'] }} faktur</div>
        </div>
        <div class="rounded-xl p-4 text-white text-center" style="background:{{ $agingData['1_30']['color'] }}">
            <div class="text-2xl font-bold">Rp {{ number_format($agingData['1_30']['total'], 0, ',', '.') }}</div>
            <div class="text-sm mt-1 opacity-80">{{ $agingData['1_30']['label'] }}</div>
            <div class="text-xs opacity-60">{{ $agingData['1_30']['count'] }} faktur</div>
        </div>
        <div class="rounded-xl p-4 text-white text-center" style="background:{{ $agingData['31_60']['color'] }}">
            <div class="text-2xl font-bold">Rp {{ number_format($agingData['31_60']['total'], 0, ',', '.') }}</div>
            <div class="text-sm mt-1 opacity-80">{{ $agingData['31_60']['label'] }}</div>
            <div class="text-xs opacity-60">{{ $agingData['31_60']['count'] }} faktur</div>
        </div>
        <div class="rounded-xl p-4 text-white text-center" style="background:{{ $agingData['61_90']['color'] }}">
            <div class="text-2xl font-bold">Rp {{ number_format($agingData['61_90']['total'], 0, ',', '.') }}</div>
            <div class="text-sm mt-1 opacity-80">{{ $agingData['61_90']['label'] }}</div>
            <div class="text-xs opacity-60">{{ $agingData['61_90']['count'] }} faktur</div>
        </div>
        <div class="rounded-xl p-4 text-white text-center" style="background:{{ $agingData['90_plus']['color'] }}">
            <div class="text-2xl font-bold">Rp {{ number_format($agingData['90_plus']['total'], 0, ',', '.') }}</div>
            <div class="text-sm mt-1 opacity-80">{{ $agingData['90_plus']['label'] }}</div>
            <div class="text-xs opacity-60">{{ $agingData['90_plus']['count'] }} faktur</div>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-6 bg-white dark:bg-gray-800">
        <h3 class="text-lg font-bold mb-4">Ringkasan Hutang</h3>
        <div class="text-3xl font-bold text-danger-600">Rp {{ number_format($totalOutstanding, 0, ',', '.') }}</div>
        <p class="text-sm text-gray-500 mt-1">Total outstanding hutang ke supplier</p>
    </div>
</x-filament-panels::page>
