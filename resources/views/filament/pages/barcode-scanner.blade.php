<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-2xl p-8 text-white">
            <div class="flex items-center gap-4 mb-6">
                <div class="flex items-center justify-center w-14 h-14 bg-white/20 rounded-2xl backdrop-blur">
                    <x-heroicon-o-qr-code class="w-8 h-8" />
                </div>
                <div>
                    <h2 class="text-2xl font-bold">Scan Barcode</h2>
                    <p class="text-indigo-200 text-sm">Arahkan scanner barcode atau ketik manual kode barcode produk</p>
                </div>
            </div>

            <div class="max-w-xl">
                {{ $this->form }}
            </div>
        </div>

        @if($result)
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-green-50 to-white">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 bg-green-100 rounded-lg">
                        <x-heroicon-o-check class="w-6 h-6 text-green-600" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $result['variant']['name'] }}</h3>
                        <p class="text-sm text-gray-500">SKU: <span class="font-mono text-gray-700">{{ $result['variant']['internal_sku'] }}</span></p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Informasi Produk</h4>
                        <dl class="space-y-2">
                            <div class="flex justify-between py-1.5 border-b border-gray-100">
                                <dt class="text-sm text-gray-500">Produk Induk</dt>
                                <dd class="text-sm font-medium text-gray-800">{{ $result['variant']['product']['name'] ?? '—' }}</dd>
                            </div>
                            <div class="flex justify-between py-1.5 border-b border-gray-100">
                                <dt class="text-sm text-gray-500">Barcode</dt>
                                <dd class="text-sm font-mono text-gray-800">{{ $result['variant']['barcode'] ?? '—' }}</dd>
                            </div>
                            <div class="flex justify-between py-1.5 border-b border-gray-100">
                                <dt class="text-sm text-gray-500">Harga Beli</dt>
                                <dd class="text-sm font-medium text-gray-800">Rp {{ number_format($result['variant']['purchase_price'] ?? 0, 0, ',', '.') }}</dd>
                            </div>
                            <div class="flex justify-between py-1.5 border-b border-gray-100">
                                <dt class="text-sm text-gray-500">Harga Jual</dt>
                                <dd class="text-sm font-semibold text-indigo-600">Rp {{ number_format($result['variant']['selling_price'] ?? 0, 0, ',', '.') }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div>
                        <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Status Stok per Gudang</h4>
                        @if(!empty($result['balances']))
                        <div class="overflow-hidden rounded-lg border border-gray-200">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-400 uppercase">Gudang</th>
                                        <th class="px-4 py-2 text-right text-xs font-semibold text-gray-400 uppercase">On Hand</th>
                                        <th class="px-4 py-2 text-right text-xs font-semibold text-gray-400 uppercase">Available</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($result['balances'] as $bal)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2.5 text-gray-700">{{ $bal['warehouse'] }}</td>
                                        <td class="px-4 py-2.5 text-right font-mono text-gray-700">{{ number_format($bal['on_hand'], 2) }}</td>
                                        <td class="px-4 py-2.5 text-right font-mono {{ $bal['available'] < 0 ? 'text-red-600 font-semibold' : 'text-gray-700' }}">
                                            {{ number_format($bal['available'], 2) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-sm text-gray-400 py-4 text-center border border-dashed border-gray-200 rounded-lg">
                            Belum ada stok di gudang manapun
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(!$result)
        <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
            <div class="flex items-center justify-center w-20 h-20 bg-gray-100 rounded-2xl mx-auto mb-4">
                <x-heroicon-o-qr-code class="w-10 h-10 text-gray-300" />
            </div>
            <h3 class="text-lg font-semibold text-gray-600 mb-1">Siap Menerima Scan</h3>
            <p class="text-sm text-gray-400 max-w-md mx-auto">Scan barcode produk menggunakan barcode scanner, atau ketik manual kode barcode di kolom input di atas lalu tekan Enter</p>
        </div>
        @endif
    </div>
</x-filament-panels::page>
