<?php

namespace App\Console\Commands;

use App\Models\SalesInvoice;
use App\Services\NotificationService;
use Illuminate\Console\Command;

class SendInvoiceReminders extends Command
{
    protected $signature = 'app:send-invoice-reminders';
    protected $description = 'Send email reminders for invoices due within 3 days';

    public function handle(): int
    {
        $invoices = SalesInvoice::where('status', 'open')
            ->where('due_date', '>=', now())
            ->where('due_date', '<=', now()->addDays(3))
            ->get();

        $count = 0;
        foreach ($invoices as $invoice) {
            if ($invoice->customer && $invoice->customer->email) {
                NotificationService::sendInvoiceDueReminder($invoice);
            } else {
                NotificationService::createInternalNotification(
                    $invoice->sales_id ?? 1,
                    'invoice_reminder',
                    'Pengingat Pembayaran',
                    "Faktur #{$invoice->invoice_no} jatuh tempo {$invoice->due_date->format('d/m/Y')}. Customer tidak memiliki email.",
                    ['invoice_id' => $invoice->id, 'invoice_no' => $invoice->invoice_no]
                );
            }

            $count++;
        }

        $this->info("Sent {$count} invoice reminders.");
        return self::SUCCESS;
    }
}
