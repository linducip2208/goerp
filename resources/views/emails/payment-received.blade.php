{{-- resources/views/emails/payment-received.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #059669; color: #fff; padding: 20px; border-radius: 8px 8px 0 0; }
        .content { background: #fff; padding: 20px; border: 1px solid #e2e8f0; border-radius: 0 0 8px 8px; }
        .detail-table td { padding: 4px 12px 4px 0; }
        .label { color: #64748b; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0;">Pembayaran Diterima</h2>
            <p style="margin:4px 0 0;opacity:0.9;">Faktur #{{ $invoice->invoice_no }}</p>
        </div>
        <div class="content">
            <p>Yth. {{ $invoice->customer->name ?? 'Pelanggan' }},</p>
            <p>Pembayaran untuk faktur berikut telah kami terima:</p>

            <table class="detail-table">
                <tr><td class="label">No. Faktur</td><td>: {{ $invoice->invoice_no }}</td></tr>
                <tr><td class="label">Tanggal</td><td>: {{ $invoice->invoice_date?->format('d/m/Y') }}</td></tr>
                <tr><td class="label">Total</td><td>: Rp {{ number_format($invoice->grand_total, 2, ',', '.') }}</td></tr>
                <tr><td class="label">Terbayar</td><td>: Rp {{ number_format($invoice->paid_amount, 2, ',', '.') }}</td></tr>
                <tr><td class="label">Status</td><td>: <strong>LUNAS</strong></td></tr>
            </table>

            <p>Terima kasih atas pembayaran Anda. Silakan simpan email ini sebagai bukti pembayaran.</p>
            <p>Hormat kami,<br>{{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>
