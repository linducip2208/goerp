<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Laba Rugi</title>
    <style>
        @page { margin: 20px 25px; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: #1e293b; line-height: 1.5; }
        .header { border-bottom: 2px solid #7c3aed; padding-bottom: 12px; margin-bottom: 16px; text-align: center; }
        .company-name { font-size: 16px; font-weight: bold; color: #5b21b6; }
        .report-title { font-size: 18px; font-weight: bold; color: #5b21b6; margin-top: 4px; }
        .period { font-size: 10px; color: #64748b; margin-top: 2px; }
        .section-title { font-size: 13px; font-weight: bold; color: #5b21b6; border-bottom: 1px solid #7c3aed; padding-bottom: 4px; margin-top: 18px; margin-bottom: 8px; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        .data-table td { padding: 4px 8px; font-size: 10px; border-bottom: 1px solid #f1f5f9; }
        .data-table .label { text-align: left; }
        .data-table .value { text-align: right; font-weight: 500; }
        .data-table .indent { padding-left: 20px; }
        .data-table .total-row td { font-weight: bold; border-top: 1px solid #cbd5e1; padding-top: 6px; }
        .data-table .grand-row td { font-weight: bold; font-size: 12px; border-top: 3px double #5b21b6; padding-top: 8px; color: #5b21b6; }
        .footer { border-top: 1px solid #e2e8f0; padding-top: 10px; font-size: 9px; color: #94a3b8; text-align: center; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">{{ $company_name ?? config('app.name') }}</div>
        <div class="report-title">LAPORAN LABA RUGI</div>
        <div class="period">Periode: {{ $period ?? '-' }}</div>
    </div>

    {{-- PENDAPATAN --}}
    <div class="section-title">PENDAPATAN</div>
    <table class="data-table">
        <tr>
            <td class="label indent">Penjualan</td>
            <td class="value">Rp {{ number_format($revenue->sales ?? 0, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label indent">Retur Penjualan</td>
            <td class="value">Rp {{ number_format($revenue->sales_return ?? 0, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label indent">Diskon Penjualan</td>
            <td class="value">Rp {{ number_format($revenue->sales_discount ?? 0, 2, ',', '.') }}</td>
        </tr>
        <tr class="total-row">
            <td class="label">Total Pendapatan</td>
            <td class="value">Rp {{ number_format(($revenue->sales ?? 0) - ($revenue->sales_return ?? 0) - ($revenue->sales_discount ?? 0), 2, ',', '.') }}</td>
        </tr>
    </table>

    {{-- HPP --}}
    <div class="section-title">HARGA POKOK PENJUALAN</div>
    <table class="data-table">
        <tr>
            <td class="label indent">HPP Penjualan</td>
            <td class="value">Rp {{ number_format($cogs->cost_of_goods ?? 0, 2, ',', '.') }}</td>
        </tr>
        <tr class="total-row">
            <td class="label">Total HPP</td>
            <td class="value">Rp {{ number_format($cogs->cost_of_goods ?? 0, 2, ',', '.') }}</td>
        </tr>
    </table>

    {{-- LABA KOTOR --}}
    @php
        $totalRevenue = ($revenue->sales ?? 0) - ($revenue->sales_return ?? 0) - ($revenue->sales_discount ?? 0);
        $totalCogs = $cogs->cost_of_goods ?? 0;
        $grossProfit = $totalRevenue - $totalCogs;
    @endphp
    <table class="data-table">
        <tr class="grand-row">
            <td class="label">LABA KOTOR</td>
            <td class="value">Rp {{ number_format($grossProfit, 2, ',', '.') }}</td>
        </tr>
    </table>

    {{-- BEBAN --}}
    <div class="section-title">BEBAN OPERASIONAL</div>
    <table class="data-table">
        @foreach($expenses as $expense)
        <tr>
            <td class="label indent">{{ $expense->account_name ?? 'Beban' }}</td>
            <td class="value">Rp {{ number_format($expense->amount ?? 0, 2, ',', '.') }}</td>
        </tr>
        @endforeach
        @php $totalExpenses = collect($expenses)->sum('amount'); @endphp
        <tr class="total-row">
            <td class="label">Total Beban</td>
            <td class="value">Rp {{ number_format($totalExpenses, 2, ',', '.') }}</td>
        </tr>
    </table>

    {{-- LABA BERSIH --}}
    @php $netProfit = $grossProfit - $totalExpenses; @endphp
    <table class="data-table">
        <tr class="grand-row">
            <td class="label">LABA (RUGI) BERSIH</td>
            <td class="value">Rp {{ number_format($netProfit, 2, ',', '.') }}</td>
        </tr>
    </table>

    <div class="footer">
        Dicetak dari GoERP &mdash; {{ now()->format('d/m/Y H:i') }} WIB
    </div>
</body>
</html>
