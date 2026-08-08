<x-filament-panels::page>
    <div class="space-y-6">
        {{ $this->form }}

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
</x-filament-panels::page>
