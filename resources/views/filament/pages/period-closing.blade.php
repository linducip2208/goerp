<x-filament-panels::page>
    {{ $this->form }}

    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Checklist Tutup Buku</h2>

        <div class="space-y-3">
            <label class="flex items-center gap-3 p-4 bg-white border rounded-xl hover:bg-gray-50 transition cursor-pointer">
                <input type="checkbox" wire:model="bankReconciled" class="w-5 h-5 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                <div>
                    <span class="font-medium text-gray-900">Rekonsiliasi Bank</span>
                    <p class="text-sm text-gray-500">Pastikan semua transaksi bank sudah direkonsiliasi dengan statement bank.</p>
                </div>
            </label>

            <label class="flex items-center gap-3 p-4 bg-white border rounded-xl hover:bg-gray-50 transition cursor-pointer">
                <input type="checkbox" wire:model="stockOpnameDone" class="w-5 h-5 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                <div>
                    <span class="font-medium text-gray-900">Stock Opname</span>
                    <p class="text-sm text-gray-500">Lakukan perhitungan fisik persediaan dan sesuaikan dengan sistem.</p>
                </div>
            </label>

            <label class="flex items-center gap-3 p-4 bg-white border rounded-xl hover:bg-gray-50 transition cursor-pointer">
                <input type="checkbox" wire:model="depreciationDone" class="w-5 h-5 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                <div>
                    <span class="font-medium text-gray-900">Penyusutan Aset</span>
                    <p class="text-sm text-gray-500">Hitung dan catat penyusutan aset tetap periode ini.</p>
                </div>
            </label>

            <label class="flex items-center gap-3 p-4 bg-white border rounded-xl hover:bg-gray-50 transition cursor-pointer">
                <input type="checkbox" wire:model="trialBalanceDone" class="w-5 h-5 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                <div>
                    <span class="font-medium text-gray-900">Review Neraca Saldo</span>
                    <p class="text-sm text-gray-500">Pastikan total debit dan kredit seimbang di neraca saldo.</p>
                </div>
            </label>
        </div>
    </div>

    <div class="flex justify-end mb-6">
        <x-filament::button wire:click="closePeriod" color="warning" icon="heroicon-o-check-badge">
            Tutup Buku
        </x-filament::button>
    </div>

    @if($closingResult)
        <x-filament::section>
            <div class="flex items-center gap-3 text-green-700 bg-green-50 rounded-lg p-4">
                <x-heroicon-o-check-circle class="w-6 h-6 text-green-600" />
                <div>
                    <div class="font-semibold">Tutup Buku Berhasil</div>
                    <div class="text-sm">{{ $closingResult }}</div>
                </div>
            </div>
        </x-filament::section>
    @endif
</x-filament-panels::page>
