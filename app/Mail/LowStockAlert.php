<?php

namespace App\Mail;

use App\Models\ProductVariant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LowStockAlert extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ProductVariant $variant,
        public string $warehouseName,
        public float $onHand,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Stok Rendah: ' . $this->variant->name . ' (' . $this->warehouseName . ')',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.low-stock-alert',
        );
    }
}
