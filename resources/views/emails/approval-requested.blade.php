{{-- resources/views/emails/approval-requested.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #d97706; color: #fff; padding: 20px; border-radius: 8px 8px 0 0; }
        .content { background: #fff; padding: 20px; border: 1px solid #e2e8f0; border-radius: 0 0 8px 8px; }
        .detail-table td { padding: 4px 12px 4px 0; }
        .label { color: #64748b; }
        .cta { display: inline-block; background: #d97706; color: #fff; padding: 12px 24px; border-radius: 6px; text-decoration: none; margin-top: 16px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0;">Permintaan Persetujuan</h2>
            <p style="margin:4px 0 0;opacity:0.9;">{{ $approval->document_no ?? 'Dokumen #' . $approval->id }}</p>
        </div>
        <div class="content">
            <p>Yth. {{ $approval->approvedBy->name ?? 'Approver' }},</p>
            <p>Ada permintaan persetujuan yang menunggu tindakan Anda:</p>

            <table class="detail-table">
                <tr><td class="label">Dokumen</td><td>: {{ $approval->document_no ?? '-' }}</td></tr>
                <tr><td class="label">Tipe</td><td>: {{ class_basename($approval->approvable_type) }}</td></tr>
                <tr><td class="label">Diajukan Oleh</td><td>: {{ $approval->submittedBy->name ?? '-' }}</td></tr>
                <tr><td class="label">Tanggal</td><td>: {{ $approval->submitted_at?->format('d/m/Y H:i') }}</td></tr>
                <tr><td class="label">Status</td><td>: {{ strtoupper($approval->status) }}</td></tr>
            </table>

            <p>Silakan login ke sistem untuk menyetujui atau menolak permintaan ini.</p>

            <p>Terima kasih.</p>
            <p>{{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>
