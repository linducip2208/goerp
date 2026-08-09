<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="rounded-xl p-5 border bg-blue-50 border-blue-200">
            <div class="text-sm text-blue-600 font-medium">Total Debit</div>
            <div class="text-2xl font-bold text-blue-700 mt-1">Rp {{ number_format($totalDebit, 0, ',', '.') }}</div>
        </div>
        <div class="rounded-xl p-5 border {{ $totalDebit === $totalCredit ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
            <div class="text-sm {{ $totalDebit === $totalCredit ? 'text-green-600' : 'text-red-600' }} font-medium">
                Total Kredit
                @if($totalDebit !== $totalCredit)
                <span class="text-xs ml-2">(Tidak balance!)</span>
                @endif
            </div>
            <div class="text-2xl font-bold {{ $totalDebit === $totalCredit ? 'text-green-700' : 'text-red-700' }} mt-1">
                Rp {{ number_format($totalCredit, 0, ',', '.') }}
            </div>
        </div>
    </div>

    @if(count($accounts) > 0)
    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-900">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Akun</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Debit</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Kredit</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Saldo</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($accounts as $acc)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-4 py-2.5 text-sm text-gray-500 font-mono">{{ $acc['code'] }}</td>
                    <td class="px-4 py-2.5 text-sm font-medium">{{ $acc['name'] }}</td>
                    <td class="px-4 py-2.5 text-sm text-right">Rp {{ number_format($acc['debit'], 0, ',', '.') }}</td>
                    <td class="px-4 py-2.5 text-sm text-right">Rp {{ number_format($acc['credit'], 0, ',', '.') }}</td>
                    <td class="px-4 py-2.5 text-sm text-right font-semibold {{ $acc['balance'] >= 0 ? 'text-gray-900' : 'text-red-600' }}">
                        Rp {{ number_format($acc['balance'], 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50 dark:bg-gray-900 font-semibold">
                <tr>
                    <td class="px-4 py-3 text-sm" colspan="2">Total</td>
                    <td class="px-4 py-3 text-sm text-right">Rp {{ number_format($totalDebit, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-sm text-right">Rp {{ number_format($totalCredit, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-sm text-right {{ $totalDebit === $totalCredit ? 'text-green-600' : 'text-red-600' }}">
                        {{ $totalDebit === $totalCredit ? 'Balanced' : 'Selisih: ' . number_format(abs($totalDebit - $totalCredit), 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    @else
    <div class="rounded-xl border border-gray-200 p-8 text-center text-gray-500">Belum ada data jurnal.</div>
    @endif
</x-filament-panels::page>
