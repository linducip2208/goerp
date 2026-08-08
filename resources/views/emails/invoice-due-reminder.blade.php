{{-- resources/views/emails/invoice-due-reminder.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #2563eb; color: #fff; padding: 20px; border-radius: 8px 8px 0 0; }
        .content { background: #fff; padding: 20px; border: 1px solid #e2e8f0; border-radius: 0 0 8px 8px; }
        .detail-table td { padding: 4px 12px 4px 0; }
        .label { color: #64748b; }
        .amount { font-size: 20px; font-weight: bold; color: #2563eb; }
        .cta { display: inline-block; background: #2563eb; color: #fff; padding: 12px 24px; border-radius: 6px; text-decoration: none; margin-top: 16px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0;">Pengingat Pembayaran</h2>
            <p style="margin:4px 0 0;opacity:0.9;">Faktur #{{ $invoice->invoice_no }}</p>
        </div>
        <div class="content">
            <p>Yth. {{ $invoice->customer->name ?? 'Pelanggan' }},</p>
            <p>Kami ingin mengingatkan bahwa faktur berikut ini akan segera jatuh tempo:</p>

            <table class="detail-table">
                <tr><td class="label">No. Faktur</td><td>: {{ $invoice->invoice_no }}</td></tr>
                <tr><td class="label">Tanggal</td><td>: {{ $invoice->invoice_date?->format('d/m/Y') }}</td></tr>
                <tr><td class="label">Jatuh Tempo</td><td>: {{ $invoice->due_date?->format('d/m/Y') }}</td></tr>
                <tr><td class="label">Status</td><td>: {{ strtoupper($invoice->status) }}</td></tr>
            </table>

            <p>Total yang harus dibayar:</p>
            <div class="amount">Rp {{ number_format($invoice->outstanding, 2, ',', '.') }}</div>

            <p>Mohon segera lakukan pembayaran sebelum tanggal jatuh tempo untuk menghindari keterlambatan.</p>
            <p>Jika sudah melakukan pembayaran, silakan abaikan email ini.</p>

            <p>Terima kasih atas perhatian dan kerjasamanya.</p>
            <p>Hormat kami,<br>{{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>
