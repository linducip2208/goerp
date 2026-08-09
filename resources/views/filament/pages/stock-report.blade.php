<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<x-filament-panels::page>
    <div class="space-y-6">
        {{ $this->form }}

        @php
            $stockValues = [];
            foreach ($balances as $bal) {
                $qty = $bal['on_hand'] ?? 0;
                $cost = $bal['average_cost'] ?? 0;
                $val = $qty * $cost;
                $name = $bal['product_variant']['internal_sku'] ?? ($bal['product_variant']['name'] ?? 'Unknown');
                if ($val > 0) {
                    $stockValues[] = ['name' => $name, 'value' => round($val, 2)];
                }
            }
            usort($stockValues, fn($a, $b) => $b['value'] <=> $a['value']);
            $stockValues = array_slice($stockValues, 0, 15);
            $stockLabels = array_map(fn($s) => $s['name'], $stockValues);
            $stockData = array_map(fn($s) => $s['value'], $stockValues);
            $totalStockValue = array_sum($stockData);
        @endphp

        <div class="grid grid-cols-3 gap-4">
            <div class="bg-blue-50 rounded-xl p-5 border border-blue-200">
                <div class="text-sm text-blue-600 font-medium">Total SKU</div>
                <div class="text-2xl font-bold text-blue-700 mt-1">{{ count($balances) }}</div>
            </div>
            <div class="bg-green-50 rounded-xl p-5 border border-green-200">
                <div class="text-sm text-green-600 font-medium">Total On Hand</div>
                @php $totalOnHand = array_sum(array_column($balances, 'on_hand')); @endphp
                <div class="text-2xl font-bold text-green-700 mt-1">{{ number_format($totalOnHand, 2) }}</div>
            </div>
            <div class="bg-purple-50 rounded-xl p-5 border border-purple-200">
                <div class="text-sm text-purple-600 font-medium">Nilai Stok</div>
                <div class="text-2xl font-bold text-purple-700 mt-1">{{ number_format($totalStockValue, 2) }}</div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800">Top 15 Produk - Nilai Stok</h3>
            </div>
            <div class="p-6">
                <canvas id="stockChart" height="120"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800">Saldo Inventaris</h3>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gudang</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">On Hand</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Reserved</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Available</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Avg Cost</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($balances as $bal)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 text-sm text-gray-700 font-mono">{{ $bal['product_variant']['internal_sku'] ?? '-' }}</td>
                        <td class="px-6 py-3 text-sm text-gray-700">{{ $bal['product_variant']['name'] ?? $bal['product_variant']['product']['name'] ?? '-' }}</td>
                        <td class="px-6 py-3 text-sm text-gray-700">{{ $bal['warehouse']['name'] ?? '-' }}</td>
                        <td class="px-6 py-3 text-sm text-gray-700 text-right">{{ number_format($bal['on_hand'] ?? 0, 2) }}</td>
                        <td class="px-6 py-3 text-sm text-gray-700 text-right">{{ number_format($bal['reserved'] ?? 0, 2) }}</td>
                        <td class="px-6 py-3 text-sm text-gray-700 text-right {{ ($bal['available'] ?? 0) < 0 ? 'text-red-600 font-semibold' : '' }}">
                            {{ number_format($bal['available'] ?? 0, 2) }}
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-700 text-right font-mono">{{ number_format($bal['average_cost'] ?? 0, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-400">Tidak ada data stok</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
<script>
    const stCtx = document.getElementById('stockChart').getContext('2d');
    new Chart(stCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($stockLabels) !!},
            datasets: [{
                label: 'Nilai Stok (Rp)',
                data: {!! json_encode($stockData) !!},
                backgroundColor: '#8b5cf6',
                borderRadius: 8,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: ctx => 'Rp ' + new Intl.NumberFormat('id-ID').format(ctx.raw)
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        callback: v => new Intl.NumberFormat('id-ID', {notation: 'compact'}).format(v)
                    }
                }
            }
        }
    });
</script>
</x-filament-panels::page>
