@extends('portal.layout')

@section('title', 'Detail Faktur')
@section('content')
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('portal.invoices') }}" class="text-stone-400 hover:text-stone-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h1 class="text-2xl font-bold text-stone-900">Faktur #{{ $invoice->invoice_no }}</h1>
    </div>

    {{-- Invoice Header --}}
    <div class="bg-white rounded-2xl border border-stone-200 shadow-sm p-6 mb-6">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            <div>
                <div class="text-stone-400 text-xs font-semibold uppercase tracking-wider mb-1">Tanggal</div>
                <div class="text-stone-800 font-medium">{{ $invoice->invoice_date->format('d M Y') }}</div>
            </div>
            <div>
                <div class="text-stone-400 text-xs font-semibold uppercase tracking-wider mb-1">Jatuh Tempo</div>
                <div class="text-stone-800 font-medium">{{ $invoice->due_date->format('d M Y') }}</div>
            </div>
            <div>
                <div class="text-stone-400 text-xs font-semibold uppercase tracking-wider mb-1">Status</div>
                @php $colors = ['draft'=>'gray','open'=>'yellow','partial'=>'blue','paid'=>'emerald','overdue'=>'red','void'=>'red']; @endphp
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-{{ $colors[$invoice->status] ?? 'gray' }}-100 text-{{ $colors[$invoice->status] ?? 'gray' }}-700">
                    {{ match($invoice->status) { 'draft' => 'Draft', 'open' => 'Open', 'partial' => 'Partial', 'paid' => 'Lunas', 'overdue' => 'Overdue', 'void' => 'Void', default => $invoice->status } }}
                </span>
            </div>
            <div>
                <div class="text-stone-400 text-xs font-semibold uppercase tracking-wider mb-1">Mata Uang</div>
                <div class="text-stone-800 font-medium">{{ $invoice->currency ?? 'IDR' }}</div>
            </div>
        </div>
    </div>

    {{-- Items Table --}}
    <div class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-stone-100">
            <h2 class="font-semibold text-stone-800">Item Faktur</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-stone-50 text-stone-500 text-xs font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="text-left px-6 py-3">Deskripsi</th>
                        <th class="text-right px-6 py-3">Qty</th>
                        <th class="text-right px-6 py-3">Harga</th>
                        <th class="text-right px-6 py-3">Diskon</th>
                        <th class="text-right px-6 py-3">Pajak</th>
                        <th class="text-right px-6 py-3">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($invoice->items as $item)
                        <tr>
                            <td class="px-6 py-3 text-stone-800">{{ $item->description ?? ($item->productVariant?->full_name ?? 'Product') }}</td>
                            <td class="px-6 py-3 text-right font-mono text-stone-700">{{ $item->quantity }}</td>
                            <td class="px-6 py-3 text-right font-mono text-stone-700">{{ number_format($item->unit_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-3 text-right font-mono text-stone-700">{{ number_format($item->discount_amount ?? 0, 0, ',', '.') }}</td>
                            <td class="px-6 py-3 text-right font-mono text-stone-700">{{ number_format($item->tax_amount ?? 0, 0, ',', '.') }}</td>
                            <td class="px-6 py-3 text-right font-mono font-semibold text-stone-800">{{ number_format($item->total, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-stone-400">Tidak ada item</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-stone-50/50 border-t border-stone-200">
                    <tr>
                        <td colspan="5" class="px-6 py-3 text-right text-stone-500 text-sm">Subtotal</td>
                        <td class="px-6 py-3 text-right font-mono text-stone-700">{{ number_format($invoice->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @if($invoice->discount_total > 0)
                    <tr>
                        <td colspan="5" class="px-6 py-3 text-right text-stone-500 text-sm">Diskon</td>
                        <td class="px-6 py-3 text-right font-mono text-red-600">-{{ number_format($invoice->discount_total, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    @if($invoice->tax_total > 0)
                    <tr>
                        <td colspan="5" class="px-6 py-3 text-right text-stone-500 text-sm">Pajak</td>
                        <td class="px-6 py-3 text-right font-mono text-stone-700">{{ number_format($invoice->tax_total, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    <tr class="border-t border-stone-200">
                        <td colspan="5" class="px-6 py-3 text-right text-stone-700 font-semibold text-sm">Grand Total</td>
                        <td class="px-6 py-3 text-right font-mono font-bold text-stone-900">{{ number_format($invoice->grand_total, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="px-6 py-3 text-right text-stone-500 text-sm">Terbayar</td>
                        <td class="px-6 py-3 text-right font-mono text-emerald-600">{{ number_format($invoice->paid_amount, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="px-6 py-3 text-right text-stone-700 font-semibold text-sm">Sisa</td>
                        <td class="px-6 py-3 text-right font-mono font-bold text-orange-600">{{ number_format($invoice->outstanding, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Payment History --}}
    <div class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-stone-100">
            <h2 class="font-semibold text-stone-800">Riwayat Pembayaran</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-stone-50 text-stone-500 text-xs font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="text-left px-6 py-3">No. Pembayaran</th>
                        <th class="text-left px-6 py-3">Tanggal</th>
                        <th class="text-left px-6 py-3">Metode</th>
                        <th class="text-right px-6 py-3">Jumlah</th>
                        <th class="text-left px-6 py-3">Referensi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($invoice->payments as $payment)
                        <tr>
                            <td class="px-6 py-4 font-medium text-stone-800">{{ $payment->payment_no }}</td>
                            <td class="px-6 py-4 text-stone-600">{{ $payment->payment_date->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-stone-600">{{ $payment->method }}</td>
                            <td class="px-6 py-4 text-right font-mono text-emerald-600">{{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-stone-600">{{ $payment->reference ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-stone-400">Belum ada pembayaran</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
