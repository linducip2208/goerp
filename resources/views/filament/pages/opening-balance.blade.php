<x-filament-panels::page>
    <div class="space-y-6">
        {{ $this->form }}

        <!-- Summary Cards -->
        <div class="grid grid-cols-4 gap-4">
            <div class="bg-blue-50 rounded-xl p-5 border border-blue-200">
                <div class="text-sm text-blue-600 font-medium">Total Debit</div>
                <div class="text-2xl font-bold text-blue-700 mt-1">
                    Rp {{ number_format(collect($this->accountEntries)->sum(fn($e) => floatval($e['debit'] ?? 0)), 2, ',', '.') }}
                </div>
            </div>
            <div class="bg-green-50 rounded-xl p-5 border border-green-200">
                <div class="text-sm text-green-600 font-medium">Total Kredit</div>
                <div class="text-2xl font-bold text-green-700 mt-1">
                    Rp {{ number_format(collect($this->accountEntries)->sum(fn($e) => floatval($e['credit'] ?? 0)), 2, ',', '.') }}
                </div>
            </div>
            @php
                $totalDebit = collect($this->accountEntries)->sum(fn($e) => floatval($e['debit'] ?? 0));
                $totalCredit = collect($this->accountEntries)->sum(fn($e) => floatval($e['credit'] ?? 0));
                $isBalanced = abs($totalDebit - $totalCredit) < 0.01;
                $isEmpty = $totalDebit == 0 && $totalCredit == 0;
            @endphp
            <div class="rounded-xl p-5 border {{ $isBalanced ? 'bg-emerald-50 border-emerald-200' : 'bg-red-50 border-red-200' }}">
                <div class="text-sm font-medium {{ $isBalanced ? 'text-emerald-600' : 'text-red-600' }}">Selisih</div>
                <div class="text-2xl font-bold mt-1 {{ $isBalanced ? 'text-emerald-700' : 'text-red-700' }}">
                    Rp {{ number_format(abs($totalDebit - $totalCredit), 2, ',', '.') }}
                </div>
            </div>
            <div class="rounded-xl p-5 border {{ $isBalanced && !$isEmpty ? 'bg-emerald-50 border-emerald-200' : 'bg-red-50 border-red-200' }}">
                <div class="text-sm font-medium {{ $isBalanced && !$isEmpty ? 'text-emerald-600' : 'text-red-600' }}">Status</div>
                <div class="text-lg font-bold mt-1 {{ $isBalanced && !$isEmpty ? 'text-emerald-700' : 'text-red-700' }}">
                    @if($isEmpty)
                        Belum Ada Data
                    @elseif($isBalanced)
                        Seimbang
                    @else
                        Tidak Seimbang
                    @endif
                </div>
            </div>
        </div>

        <!-- Account Table by Category -->
        @foreach($this->accountCategories as $category)
            @php
                $categoryAccounts = collect($this->accountEntries)->where('category', $category)->values();
            @endphp
            @if($categoryAccounts->isNotEmpty())
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800 capitalize">{{ str_replace('_', ' ', $category) }}</h3>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Akun</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-48">Debit</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-48">Kredit</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($categoryAccounts as $index => $account)
                            @php
                                $accountIdx = collect($this->accountEntries)->search(fn($e) => $e['id'] == $account['id']);
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 text-sm text-gray-700 font-mono">{{ $account['code'] }}</td>
                                <td class="px-6 py-3 text-sm text-gray-700">{{ $account['name'] }}</td>
                                <td class="px-6 py-3">
                                    <input type="number"
                                        class="w-full text-right px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                        placeholder="0"
                                        min="0"
                                        step="0.01"
                                        wire:model.live.debounce.300ms="accountEntries.{{ $accountIdx }}.debit"
                                        @if(floatval($account['credit'] ?? 0) > 0) disabled @endif>
                                </td>
                                <td class="px-6 py-3">
                                    <input type="number"
                                        class="w-full text-right px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                        placeholder="0"
                                        min="0"
                                        step="0.01"
                                        wire:model.live.debounce.300ms="accountEntries.{{ $accountIdx }}.credit"
                                        @if(floatval($account['debit'] ?? 0) > 0) disabled @endif>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        @endforeach

        <!-- Save Button -->
        <div class="flex justify-end gap-3">
            <x-filament::button type="button" color="gray" tag="a" href="{{ url()->previous() }}">
                Batal
            </x-filament::button>
            <x-filament::button type="button" color="primary" wire:click="save"
                @if(!$isBalanced || $isEmpty) disabled @endif>
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Saldo Awal
                </span>
            </x-filament::button>
        </div>
    </div>
</x-filament-panels::page>
