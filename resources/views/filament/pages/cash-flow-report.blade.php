<x-filament-panels::page>
    <div class="space-y-6">
        {{ $this->form }}

        <div class="grid grid-cols-3 gap-4">
            <div class="bg-green-50 rounded-xl p-5 border border-green-200">
                <div class="text-sm text-green-600 font-medium">Kas Masuk</div>
                <div class="text-2xl font-bold text-green-700 mt-1">{{ number_format($totalIn, 2) }}</div>
            </div>
            <div class="bg-red-50 rounded-xl p-5 border border-red-200">
                <div class="text-sm text-red-600 font-medium">Kas Keluar</div>
                <div class="text-2xl font-bold text-red-700 mt-1">{{ number_format($totalOut, 2) }}</div>
            </div>
            <div class="bg-blue-50 rounded-xl p-5 border border-blue-200">
                <div class="text-sm text-blue-600 font-medium">Arus Kas Bersih</div>
                <div class="text-2xl font-bold {{ $netCashFlow >= 0 ? 'text-blue-700' : 'text-red-700' }} mt-1">{{ number_format($netCashFlow, 2) }}</div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800">Rincian Transaksi</h3>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bank</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($transactions as $txn)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 text-sm text-gray-700">{{ $txn['transaction_date'] ?? '-' }}</td>
                        <td class="px-6 py-3 text-sm text-gray-700">{{ $txn['bank_account']['name'] ?? $txn['bank_account']['account_name'] ?? '-' }}</td>
                        <td class="px-6 py-3 text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ ($txn['transaction_type'] ?? '') === 'in' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ ($txn['transaction_type'] ?? '') === 'in' ? 'Masuk' : 'Keluar' }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-700">{{ $txn['memo'] ?? $txn['description'] ?? '-' }}</td>
                        <td class="px-6 py-3 text-sm text-gray-700 text-right font-mono">{{ number_format($txn['amount'] ?? 0, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Tidak ada transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>
