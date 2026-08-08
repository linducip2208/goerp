<?php

namespace App\Mail;

use App\Models\SalesInvoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceDueReminder extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public SalesInvoice $invoice
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengingat: Faktur ' . $this->invoice->invoice_no . ' Akan Jatuh Tempo',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice-due-reminder',
        );
    }
}
