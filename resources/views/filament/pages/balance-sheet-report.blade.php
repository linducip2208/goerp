<x-filament-panels::page>
    <div class="space-y-6">
        {{ $this->form }}

        <div class="grid grid-cols-3 gap-4">
            <div class="bg-blue-50 rounded-xl p-5 border border-blue-200">
                <div class="text-sm text-blue-600 font-medium">Total Aset</div>
                <div class="text-2xl font-bold text-blue-700 mt-1">{{ number_format($totalAssets, 2) }}</div>
            </div>
            <div class="bg-red-50 rounded-xl p-5 border border-red-200">
                <div class="text-sm text-red-600 font-medium">Total Liabilitas</div>
                <div class="text-2xl font-bold text-red-700 mt-1">{{ number_format(abs($totalLiabilities), 2) }}</div>
            </div>
            <div class="bg-green-50 rounded-xl p-5 border border-green-200">
                <div class="text-sm text-green-600 font-medium">Total Ekuitas</div>
                <div class="text-2xl font-bold text-green-700 mt-1">{{ number_format($totalEquity, 2) }}</div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            @if(!empty($assets))
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-blue-50">
                    <h3 class="text-lg font-semibold text-blue-800">Aset</h3>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akun</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($assets as $account => $amount)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3 text-sm text-gray-700">{{ $account }}</td>
                            <td class="px-6 py-3 text-sm text-gray-700 text-right">{{ number_format($amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <div class="space-y-6">
                @if(!empty($liabilities))
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-red-50">
                        <h3 class="text-lg font-semibold text-red-800">Liabilitas</h3>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akun</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($liabilities as $account => $amount)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 text-sm text-gray-700">{{ $account }}</td>
                                <td class="px-6 py-3 text-sm text-gray-700 text-right">{{ number_format(abs($amount), 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

                @if(!empty($equity))
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-green-50">
                        <h3 class="text-lg font-semibold text-green-800">Ekuitas</h3>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akun</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($equity as $account => $amount)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 text-sm text-gray-700">{{ $account }}</td>
                                <td class="px-6 py-3 text-sm text-gray-700 text-right">{{ number_format($amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>

        <div class="bg-purple-50 rounded-xl p-5 border border-purple-200">
            <div class="flex justify-between items-center">
                <span class="font-medium text-purple-700">Equilibrium Check</span>
                <span class="font-bold {{ abs($totalAssets - abs($totalLiabilities) - $totalEquity) < 0.01 ? 'text-green-600' : 'text-red-600' }}">
                    {{ abs($totalAssets - abs($totalLiabilities) - $totalEquity) < 0.01 ? 'Balance' : 'Out of Balance: ' . number_format($totalAssets - abs($totalLiabilities) - $totalEquity, 2) }}
                </span>
            </div>
        </div>
    </div>
</x-filament-panels::page>
