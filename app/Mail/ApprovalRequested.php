<?php

namespace App\Mail;

use App\Models\Approval;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApprovalRequested extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Approval $approval
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Permintaan Persetujuan - ' . ($this->approval->document_no ?? 'Dokumen #' . $this->approval->id),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.approval-requested',
        );
    }
}
