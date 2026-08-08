@extends('portal.layout')

@section('title', 'Pembayaran')
@section('content')
    <h1 class="text-2xl font-bold text-stone-900 mb-6">Riwayat Pembayaran</h1>

    <div class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-stone-50 text-stone-500 text-xs font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="text-left px-6 py-3">No</th>
                        <th class="text-left px-6 py-3">No. Pembayaran</th>
                        <th class="text-left px-6 py-3">Faktur</th>
                        <th class="text-left px-6 py-3">Tanggal</th>
                        <th class="text-left px-6 py-3">Metode</th>
                        <th class="text-right px-6 py-3">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($payments as $index => $payment)
                        <tr class="hover:bg-stone-50/50 transition-colors">
                            <td class="px-6 py-4 text-stone-500">{{ $payments->firstItem() + $index }}</td>
                            <td class="px-6 py-4 font-medium text-stone-800">{{ $payment->payment_no }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('portal.invoice.detail', $payment->invoice_id) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                    {{ $payment->invoice->invoice_no ?? '-' }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-stone-600">{{ $payment->payment_date->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-stone-600">{{ $payment->method }}</td>
                            <td class="px-6 py-4 text-right font-mono text-emerald-600 font-semibold">{{ number_format($payment->amount, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-stone-400">Belum ada pembayaran</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($payments->hasPages())
            <div class="px-6 py-4 border-t border-stone-100">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
@endsection
