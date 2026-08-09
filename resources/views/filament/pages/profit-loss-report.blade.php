<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<x-filament-panels::page>
    <div class="space-y-6">
        {{ $this->form }}

        <div class="grid grid-cols-5 gap-4">
            <div class="bg-green-50 rounded-xl p-5 border border-green-200">
                <div class="text-sm text-green-600 font-medium">Pendapatan</div>
                <div class="text-2xl font-bold text-green-700 mt-1">{{ number_format($summary['revenue'] ?? 0, 2) }}</div>
            </div>
            <div class="bg-red-50 rounded-xl p-5 border border-red-200">
                <div class="text-sm text-red-600 font-medium">HPP (COGS)</div>
                <div class="text-2xl font-bold text-red-700 mt-1">{{ number_format($summary['cogs'] ?? 0, 2) }}</div>
            </div>
            <div class="bg-blue-50 rounded-xl p-5 border border-blue-200">
                <div class="text-sm text-blue-600 font-medium">Laba Kotor</div>
                <div class="text-2xl font-bold text-blue-700 mt-1">{{ number_format($summary['gross_profit'] ?? 0, 2) }}</div>
            </div>
            <div class="bg-orange-50 rounded-xl p-5 border border-orange-200">
                <div class="text-sm text-orange-600 font-medium">Biaya Operasional</div>
                <div class="text-2xl font-bold text-orange-700 mt-1">{{ number_format($summary['expense'] ?? 0, 2) }}</div>
            </div>
            <div class="bg-purple-50 rounded-xl p-5 border border-purple-200">
                <div class="text-sm text-purple-600 font-medium">Laba Bersih</div>
                <div class="text-2xl font-bold text-purple-700 mt-1">{{ number_format($summary['net_profit'] ?? 0, 2) }}</div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800">Grafik Laba Rugi</h3>
            </div>
            <div class="p-6">
                <canvas id="profitLossChart" height="120"></canvas>
            </div>
        </div>

        @if(!empty($results['revenue']))
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800">Rincian Pendapatan</h3>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akun</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($results['revenue'] as $account => $amount)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 text-sm text-gray-700">{{ $account }}</td>
                        <td class="px-6 py-3 text-sm text-gray-700 text-right">{{ number_format($amount, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-green-50 font-semibold">
                        <td class="px-6 py-3 text-sm text-green-700">Total Pendapatan</td>
                        <td class="px-6 py-3 text-sm text-green-700 text-right">{{ number_format($summary['revenue'] ?? 0, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @endif

        @if(!empty($results['cogs']))
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800">Rincian HPP (COGS)</h3>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akun</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($results['cogs'] as $account => $amount)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 text-sm text-gray-700">{{ $account }}</td>
                        <td class="px-6 py-3 text-sm text-gray-700 text-right">{{ number_format(abs($amount), 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        @if(!empty($results['expense']))
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800">Rincian Biaya Operasional</h3>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akun</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($results['expense'] as $account => $amount)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 text-sm text-gray-700">{{ $account }}</td>
                        <td class="px-6 py-3 text-sm text-gray-700 text-right">{{ number_format($amount, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-orange-50 font-semibold">
                        <td class="px-6 py-3 text-sm text-orange-700">Total Biaya</td>
                        <td class="px-6 py-3 text-sm text-orange-700 text-right">{{ number_format($summary['expense'] ?? 0, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @endif
    </div>
<script>
    const plCtx = document.getElementById('profitLossChart').getContext('2d');
    new Chart(plCtx, {
        type: 'bar',
        data: {
            labels: ['Pendapatan', 'HPP', 'Laba Kotor', 'Biaya', 'Laba Bersih'],
            datasets: [{
                label: 'Jumlah (Rp)',
                data: [
                    {{ $summary['revenue'] ?? 0 }},
                    {{ $summary['cogs'] ?? 0 }},
                    {{ $summary['gross_profit'] ?? 0 }},
                    {{ $summary['expense'] ?? 0 }},
                    {{ $summary['net_profit'] ?? 0 }}
                ],
                backgroundColor: ['#22c55e', '#ef4444', '#3b82f6', '#f97316', '#8b5cf6'],
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => 'Rp ' + new Intl.NumberFormat('id-ID').format(ctx.raw)
                    }
                }
            },
            scales: {
                y: {
                    ticks: {
                        callback: v => new Intl.NumberFormat('id-ID', {notation: 'compact'}).format(v)
                    }
                }
            }
        }
    });
</script>
</x-filament-panels::page>
