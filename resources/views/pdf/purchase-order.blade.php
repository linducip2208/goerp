<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Purchase Order {{ $order->order_no }}</title>
    <style>
        @page { margin: 20px 25px; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: #1e293b; line-height: 1.5; }
        .header { border-bottom: 2px solid #059669; padding-bottom: 12px; margin-bottom: 16px; }
        .header-table { width: 100%; }
        .header-table td { vertical-align: top; }
        .company-name { font-size: 16px; font-weight: bold; color: #065f46; }
        .company-detail { font-size: 9px; color: #64748b; }
        .po-title { font-size: 18px; font-weight: bold; color: #065f46; text-align: right; }
        .po-title-sub { font-size: 11px; color: #64748b; text-align: right; }
        .info-table { width: 100%; margin-bottom: 16px; border-collapse: collapse; }
        .info-table td { padding: 3px 6px; font-size: 10px; vertical-align: top; }
        .info-table .label { color: #64748b; width: 110px; }
        .info-table .value { font-weight: bold; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        .items-table th { background: #059669; color: #fff; padding: 8px 6px; font-size: 9px; text-transform: uppercase; letter-spacing: 0.5px; text-align: left; }
        .items-table th.right { text-align: right; }
        .items-table td { padding: 6px; font-size: 10px; border-bottom: 1px solid #e2e8f0; }
        .items-table td.right { text-align: right; }
        .items-table tr:nth-child(even) td { background: #f8fafc; }
        .summary-table { width: 50%; margin-left: 50%; border-collapse: collapse; margin-bottom: 20px; }
        .summary-table td { padding: 4px 8px; font-size: 10px; }
        .summary-table .label { color: #64748b; text-align: right; }
        .summary-table .value { font-weight: bold; text-align: right; }
        .summary-table .grand-row td { border-top: 2px solid #065f46; padding-top: 6px; font-size: 12px; }
        .terbilang { font-style: italic; font-size: 10px; color: #64748b; margin-bottom: 24px; }
        .footer { border-top: 1px solid #e2e8f0; padding-top: 10px; font-size: 9px; color: #94a3b8; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <table class="header-table">
            <tr>
                <td width="60%">
                    @if($company && $company->logo)
                        <img src="{{ public_path('storage/' . $company->logo) }}" style="max-height:50px; margin-bottom:6px;">
                        <br>
                    @endif
                    <div class="company-name">{{ $company->name ?? config('app.name') }}</div>
                    <div class="company-detail">
                        @if($company)
                            @if($company->npwp) NPWP: {{ $company->npwp }}<br> @endif
                            @if($company->address) {{ $company->address }}<br> @endif
                            @if($company->phone) Telp: {{ $company->phone }} @endif
                        @endif
                    </div>
                </td>
                <td width="40%">
                    <div class="po-title">PURCHASE ORDER</div>
                    <div class="po-title-sub">No. {{ $order->order_no }}</div>
                </td>
            </tr>
        </table>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">No. PO</td>
            <td class="value">: {{ $order->order_no }}</td>
            <td class="label">Supplier</td>
            <td class="value">: {{ $order->supplier->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal</td>
            <td class="value">: {{ $order->order_date?->format('d/m/Y') }}</td>
            <td class="label">NPWP Supplier</td>
            <td class="value">: {{ $order->supplier->npwp ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Estimasi Tiba</td>
            <td class="value">: {{ $order->expected_delivery?->format('d/m/Y') ?? '-' }}</td>
            <td class="label">Alamat</td>
            <td class="value">: {{ $order->supplier->address ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Status</td>
            <td class="value">: {{ strtoupper($order->status) }}</td>
            <td class="label">Term Pembayaran</td>
            <td class="value">: {{ $order->payment_term ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Gudang</td>
            <td class="value">: {{ $order->warehouse->name ?? '-' }}</td>
            <td class="label">Cabang</td>
            <td class="value">: {{ $order->branch->name ?? '-' }}</td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width:5%;">No</th>
                <th style="width:15%;">SKU</th>
                <th>Produk</th>
                <th class="right" style="width:8%;">Qty</th>
                <th class="right" style="width:8%;">Diterima</th>
                <th class="right" style="width:12%;">Harga</th>
                <th class="right" style="width:8%;">Disc%</th>
                <th class="right" style="width:8%;">Tax%</th>
                <th class="right" style="width:14%;">Subtotal</th>
                <th class="right" style="width:14%;">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($order->items as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->productVariant->internal_sku ?? '-' }}</td>
                <td>
                    {{ $item->productVariant->name ?? $item->description }}
                    @if($item->productVariant && $item->productVariant->variant_attributes)
                        <br><small style="color:#94a3b8;">
                            {{ is_array($item->productVariant->variant_attributes) ? implode(', ', $item->productVariant->variant_attributes) : $item->productVariant->variant_attributes }}
                        </small>
                    @endif
                </td>
                <td class="right">{{ number_format($item->quantity, 2, ',', '.') }}</td>
                <td class="right">{{ number_format($item->received_qty, 2, ',', '.') }}</td>
                <td class="right">{{ number_format($item->unit_price, 2, ',', '.') }}</td>
                <td class="right">{{ number_format($item->discount_percent, 2) }}%</td>
                <td class="right">{{ number_format($item->tax_percent, 2) }}%</td>
                <td class="right">{{ number_format($item->subtotal, 2, ',', '.') }}</td>
                <td class="right">{{ number_format($item->total, 2, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" style="text-align:center; color:#94a3b8; padding:20px;">Tidak ada item</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table class="summary-table">
        <tr>
            <td class="label" style="width:50%;">Subtotal</td>
            <td class="value" style="width:50%;">Rp {{ number_format($order->subtotal, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Diskon</td>
            <td class="value">Rp {{ number_format($order->discount_total, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Pajak</td>
            <td class="value">Rp {{ number_format($order->tax_total, 2, ',', '.') }}</td>
        </tr>
        <tr class="grand-row">
            <td class="label" style="font-weight:bold; color:#065f46;">Grand Total</td>
            <td class="value" style="color:#065f46;">Rp {{ number_format($order->grand_total, 2, ',', '.') }}</td>
        </tr>
    </table>

    <div class="terbilang">
        Terbilang: {{ \App\Services\ReportPdfService::terbilang($order->grand_total) }} rupiah
    </div>

    @if($order->notes)
    <div style="margin-bottom: 20px; padding: 10px; background: #f8fafc; border-radius: 4px; font-size: 10px;">
        <strong>Catatan:</strong> {{ $order->notes }}
    </div>
    @endif

    <div style="display:flex; justify-content:space-between; gap:80px; margin-bottom:30px;">
        <div style="text-align:center; font-size:10px;">
            Diterima Oleh<br><br><br><br>
            ( ___________________ )
        </div>
        <div style="text-align:center; font-size:10px;">
            Menyetujui<br><br><br><br>
            ( ___________________ )
        </div>
        <div style="text-align:center; font-size:10px;">
            Hormat Kami<br><br><br><br>
            ( ___________________ )
        </div>
    </div>

    <div class="footer">
        Dicetak dari GoERP &mdash; {{ now()->format('d/m/Y H:i') }} WIB
    </div>
</body>
</html>
