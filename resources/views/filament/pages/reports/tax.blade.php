<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="rounded-xl p-5 border bg-green-50 border-green-200">
            <div class="text-sm text-green-600 font-medium">Pajak Keluaran (Output)</div>
            <div class="text-2xl font-bold text-green-700 mt-1">Rp {{ number_format($totalOutputTax, 0, ',', '.') }}</div>
            <div class="text-xs text-green-500 mt-1">PPN dari penjualan</div>
        </div>
        <div class="rounded-xl p-5 border bg-red-50 border-red-200">
            <div class="text-sm text-red-600 font-medium">Pajak Masukan (Input)</div>
            <div class="text-2xl font-bold text-red-700 mt-1">Rp {{ number_format($totalInputTax, 0, ',', '.') }}</div>
            <div class="text-xs text-red-500 mt-1">PPN dari pembelian</div>
        </div>
        <div class="rounded-xl p-5 border {{ $netTax >= 0 ? 'bg-orange-50 border-orange-200' : 'bg-blue-50 border-blue-200' }}">
            <div class="text-sm {{ $netTax >= 0 ? 'text-orange-600' : 'text-blue-600' }} font-medium">
                {{ $netTax >= 0 ? 'Kurang Bayar' : 'Lebih Bayar' }}
            </div>
            <div class="text-2xl font-bold {{ $netTax >= 0 ? 'text-orange-700' : 'text-blue-700' }} mt-1">
                Rp {{ number_format(abs($netTax), 0, ',', '.') }}
            </div>
            <div class="text-xs {{ $netTax >= 0 ? 'text-orange-500' : 'text-blue-500' }} mt-1">
                {{ $netTax >= 0 ? 'Output - Input' : 'Input - Output' }}
            </div>
        </div>
    </div>

    @if(count($taxData) > 0)
    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
            <h3 class="text-lg font-semibold">Rincian per Tarif Pajak</h3>
        </div>
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-900">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tarif</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Pajak Keluaran</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Pajak Masukan</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Selisih</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($taxData as $row)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-3 text-sm font-medium">{{ $row['rate_name'] }}</td>
                    <td class="px-6 py-3 text-sm text-right">Rp {{ number_format($row['output'], 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-sm text-right">Rp {{ number_format($row['input'], 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-sm text-right font-semibold {{ ($row['output'] - $row['input']) >= 0 ? 'text-orange-600' : 'text-blue-600' }}">
                        Rp {{ number_format($row['output'] - $row['input'], 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-8 text-center text-gray-500">
        Tidak ada data pajak bulan ini.
    </div>
    @endif
</x-filament-panels::page>
