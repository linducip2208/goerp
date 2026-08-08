<x-filament-panels::page>
    <div class="space-y-6">
        {{ $this->form }}

        <div class="grid grid-cols-4 gap-4">
            <div class="bg-blue-50 rounded-xl p-5 border border-blue-200">
                <div class="text-sm text-blue-600 font-medium">Total Invoice</div>
                <div class="text-2xl font-bold text-blue-700 mt-1">{{ $summary['total_invoices'] ?? 0 }}</div>
            </div>
            <div class="bg-indigo-50 rounded-xl p-5 border border-indigo-200">
                <div class="text-sm text-indigo-600 font-medium">Total Item</div>
                <div class="text-2xl font-bold text-indigo-700 mt-1">{{ $summary['total_items'] ?? 0 }}</div>
            </div>
            <div class="bg-green-50 rounded-xl p-5 border border-green-200">
                <div class="text-sm text-green-600 font-medium">Total Pendapatan</div>
                <div class="text-2xl font-bold text-green-700 mt-1">{{ number_format($summary['total_revenue'] ?? 0, 2) }}</div>
            </div>
            <div class="bg-orange-50 rounded-xl p-5 border border-orange-200">
                <div class="text-sm text-orange-600 font-medium">Outstanding</div>
                <div class="text-2xl font-bold text-orange-700 mt-1">{{ number_format($summary['total_outstanding'] ?? 0, 2) }}</div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800">Daftar Invoice</h3>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Invoice</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cabang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Grand Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($invoices as $inv)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 text-sm text-gray-700 font-mono">{{ $inv['invoice_no'] ?? '-' }}</td>
                        <td class="px-6 py-3 text-sm text-gray-700">{{ $inv['invoice_date'] ?? '-' }}</td>
                        <td class="px-6 py-3 text-sm text-gray-700">{{ $inv['customer']['name'] ?? '-' }}</td>
                        <td class="px-6 py-3 text-sm text-gray-700">{{ $inv['branch']['name'] ?? '-' }}</td>
                        <td class="px-6 py-3 text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ ($inv['status'] ?? '') === 'paid' ? 'bg-green-100 text-green-700' : '' }}
                                {{ ($inv['status'] ?? '') === 'draft' ? 'bg-gray-100 text-gray-700' : '' }}
                                {{ ($inv['status'] ?? '') === 'open' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ ($inv['status'] ?? '') === 'overdue' ? 'bg-red-100 text-red-700' : '' }}
                            ">{{ $inv['status'] ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-700 text-right font-mono">{{ number_format($inv['grand_total'] ?? 0, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-400">Tidak ada data penjualan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>
