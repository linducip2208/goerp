<?php

namespace App\Console\Commands;

use App\Models\SalesInvoice;
use App\Services\AuditService;
use App\Services\NotificationService;
use Illuminate\Console\Command;

class EscalateOverdueInvoices extends Command
{
    protected $signature = 'app:escalate-overdue-invoices';
    protected $description = 'Escalate open invoices past due date to overdue status';

    public function handle(): int
    {
        $invoices = SalesInvoice::where('status', 'open')
            ->where('due_date', '<', now())
            ->get();

        $count = 0;
        foreach ($invoices as $invoice) {
            $invoice->update(['status' => 'overdue']);

            AuditService::log(
                'escalate',
                'Finance',
                'SalesInvoice',
                $invoice->id,
                $invoice->invoice_no,
                ['status' => 'open'],
                ['status' => 'overdue']
            );

            NotificationService::sendInvoiceDueReminder($invoice);

            NotificationService::createInternalNotification(
                $invoice->sales_id ?? 1,
                'overdue_invoice',
                'Faktur Jatuh Tempo',
                "Faktur #{$invoice->invoice_no} untuk {$invoice->customer->name} sudah melewati jatuh tempo.",
                ['invoice_id' => $invoice->id, 'invoice_no' => $invoice->invoice_no]
            );

            $count++;
        }

        $this->info("Escalated {$count} overdue invoices.");
        return self::SUCCESS;
    }
}
