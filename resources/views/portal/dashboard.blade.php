@extends('portal.layout')

@section('title', 'Dashboard')
@section('content')
    <h1 class="text-2xl font-bold text-stone-900 mb-6">Dashboard</h1>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-stone-200 p-5 shadow-sm">
            <div class="text-stone-400 text-xs font-semibold uppercase tracking-wider mb-2">Total Faktur</div>
            <div class="text-3xl font-bold text-stone-900">{{ $totalInvoices }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-stone-200 p-5 shadow-sm">
            <div class="text-stone-400 text-xs font-semibold uppercase tracking-wider mb-2">Total Dibayar</div>
            <div class="text-3xl font-bold text-emerald-600">{{ number_format($totalSpent, 0, ',', '.') }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-stone-200 p-5 shadow-sm">
            <div class="text-stone-400 text-xs font-semibold uppercase tracking-wider mb-2">Sisa Tagihan</div>
            <div class="text-3xl font-bold text-orange-600">{{ number_format($outstanding, 0, ',', '.') }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-stone-200 p-5 shadow-sm">
            <div class="text-stone-400 text-xs font-semibold uppercase tracking-wider mb-2">Faktur Aktif</div>
            <div class="text-3xl font-bold text-blue-600">{{ $activeOrders }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-stone-200 p-5 shadow-sm">
            <div class="text-stone-400 text-xs font-semibold uppercase tracking-wider mb-2">Lunas</div>
            <div class="text-3xl font-bold text-emerald-600">{{ $paid }}</div>
        </div>
    </div>

    {{-- Recent Invoices --}}
    <div class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-stone-100 flex items-center justify-between">
            <h2 class="font-semibold text-stone-800">Faktur Terbaru</h2>
            <a href="{{ route('portal.invoices') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Lihat Semua &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-stone-50 text-stone-500 text-xs font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="text-left px-6 py-3">No. Faktur</th>
                        <th class="text-left px-6 py-3">Tanggal</th>
                        <th class="text-left px-6 py-3">Jatuh Tempo</th>
                        <th class="text-right px-6 py-3">Total</th>
                        <th class="text-center px-6 py-3">Status</th>
                        <th class="text-center px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($recentInvoices as $inv)
                        <tr class="hover:bg-stone-50/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-stone-800">{{ $inv->invoice_no }}</td>
                            <td class="px-6 py-4 text-stone-600">{{ $inv->invoice_date->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-stone-600">{{ $inv->due_date->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-right font-mono text-stone-800">{{ number_format($inv->grand_total, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center">
                                @php $colors = ['draft'=>'gray','open'=>'warning','partial'=>'info','paid'=>'emerald','overdue'=>'red','void'=>'red']; @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-{{ $colors[$inv->status] ?? 'gray' }}-100 text-{{ $colors[$inv->status] ?? 'gray' }}-700">
                                    {{ ucfirst($inv->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('portal.invoice.detail', $inv->id) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-xs">Lihat</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-stone-400">Belum ada faktur</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
