<x-filament-panels::page>
    {{ $this->form }}

    <div class="flex justify-end mt-4 mb-6">
        <x-filament::button wire:click="load" color="primary">
            Tampilkan
        </x-filament::button>
    </div>

    @if(!empty($entries))
        <div class="grid grid-cols-3 gap-4 mb-6">
            <x-filament::section>
                <div class="text-sm text-gray-500">Saldo Awal</div>
                <div class="text-2xl font-bold {{ $openingBalance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    Rp {{ number_format($openingBalance, 0, ',', '.') }}
                </div>
            </x-filament::section>
            <x-filament::section>
                <div class="text-sm text-gray-500">Total Mutasi</div>
                @php $mutasi = collect($entries)->sum('debit') - collect($entries)->sum('credit'); @endphp
                <div class="text-2xl font-bold {{ $mutasi >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    Rp {{ number_format($mutasi, 0, ',', '.') }}
                </div>
            </x-filament::section>
            <x-filament::section>
                <div class="text-sm text-gray-500">Saldo Akhir</div>
                <div class="text-2xl font-bold {{ $closingBalance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    Rp {{ number_format($closingBalance, 0, ',', '.') }}
                </div>
            </x-filament::section>
        </div>

        <x-filament::section>
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b text-left text-gray-500">
                        <th class="py-2">Tanggal</th>
                        <th class="py-2">No. Jurnal</th>
                        <th class="py-2">Keterangan</th>
                        <th class="py-2 text-right">Debit</th>
                        <th class="py-2 text-right">Kredit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($entries as $entry)
                    <tr class="border-b">
                        <td class="py-2">{{ $entry['date'] }}</td>
                        <td class="py-2">{{ $entry['journal_no'] }}</td>
                        <td class="py-2">{{ $entry['description'] }}</td>
                        <td class="py-2 text-right">{{ $entry['debit'] > 0 ? 'Rp '.number_format($entry['debit'],0,',','.') : '-' }}</td>
                        <td class="py-2 text-right">{{ $entry['credit'] > 0 ? 'Rp '.number_format($entry['credit'],0,',','.') : '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </x-filament::section>
    @endif
</x-filament-panels::page>
