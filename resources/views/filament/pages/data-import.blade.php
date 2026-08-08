<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800">Import Data</h3>
                <p class="text-sm text-gray-500 mt-0.5">Upload file Excel (.xlsx, .xls, .csv) untuk mengimpor data secara massal</p>
            </div>
            <div class="p-6">
                {{ $this->form }}

                <div class="mt-6 flex items-center gap-3">
                    <x-filament::button wire:click="import" color="success" icon="heroicon-o-arrow-up-tray">
                        Import Data
                    </x-filament::button>

                    @if(!empty($data['import_type']))
                    <x-filament::button wire:click="downloadTemplate" color="gray" icon="heroicon-o-arrow-down-tray" outlined>
                        Download Template
                    </x-filament::button>
                    @endif
                </div>
            </div>
        </div>

        @if($preview && !empty($preview['headers']))
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-white">
                <div class="flex items-center gap-3">
                    <x-heroicon-o-eye class="w-5 h-5 text-blue-500" />
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Preview Data</h3>
                        <p class="text-sm text-gray-500">{{ $preview['total'] }} baris terdeteksi, menampilkan 5 baris pertama</p>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            @foreach($preview['headers'] as $header)
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                {{ $header }}
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($preview['rows'] as $row)
                        <tr class="hover:bg-gray-50">
                            @foreach($preview['headers'] as $header)
                            <td class="px-4 py-2.5 text-sm text-gray-700 max-w-xs truncate">
                                {{ $row[$header] ?? '' }}
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        @if($preview && isset($preview['error']))
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-sm text-red-700">
            {{ $preview['error'] }}
        </div>
        @endif

        @if($result)
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-green-50 to-white">
                <div class="flex items-center gap-3">
                    <x-heroicon-o-check-circle class="w-5 h-5 text-green-500" />
                    <h3 class="text-lg font-semibold text-gray-800">Hasil Import</h3>
                </div>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-green-50 rounded-lg p-4 border border-green-100">
                        <dt class="text-sm text-green-600 font-medium mb-1">Berhasil Diimpor</dt>
                        <dd class="text-3xl font-bold text-green-700">{{ $result['imported'] }}</dd>
                    </div>
                    <div class="bg-amber-50 rounded-lg p-4 border border-amber-100">
                        <dt class="text-sm text-amber-600 font-medium mb-1">Dilewati (Duplikat)</dt>
                        <dd class="text-3xl font-bold text-amber-700">{{ $result['skipped'] }}</dd>
                    </div>
                    <div class="bg-red-50 rounded-lg p-4 border border-red-100">
                        <dt class="text-sm text-red-600 font-medium mb-1">Error</dt>
                        <dd class="text-3xl font-bold text-red-700">{{ count($result['errors'] ?? []) }}</dd>
                    </div>
                </dl>

                @if(!empty($result['errors']))
                <div class="mt-4 space-y-1 max-h-48 overflow-y-auto">
                    @foreach($result['errors'] as $error)
                    <div class="text-sm text-red-600 bg-red-50 rounded px-3 py-1.5">{{ $error }}</div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        @endif

        <div class="bg-blue-50 border border-blue-200 rounded-xl p-5">
            <div class="flex gap-3">
                <x-heroicon-o-information-circle class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" />
                <div class="text-sm text-blue-700 space-y-1">
                    <p class="font-semibold">Format Template Excel</p>
                    <p><strong>Produk:</strong> Kolom wajib: <code>sku</code>, <code>nama_produk</code>. Opsional: <code>merek</code>, <code>satuan</code>, <code>harga_beli</code>, <code>harga_jual</code>, <code>stok_minimum</code>, <code>barcode</code></p>
                    <p><strong>Kontak:</strong> Kolom wajib: <code>kode</code>, <code>nama</code>, <code>tipe</code>. Opsional: <code>perusahaan</code>, <code>email</code>, <code>telepon</code>, <code>alamat</code>, <code>npwp</code>, <code>nik</code></p>
                    <p class="mt-2">Template contoh tersedia di <code class="bg-blue-100 px-1 rounded">public/templates/products_template.xlsx</code> dan <code class="bg-blue-100 px-1 rounded">public/templates/contacts_template.xlsx</code></p>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
