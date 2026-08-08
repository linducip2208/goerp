<?php

namespace App\Services;

use App\Mail\ApprovalRequested;
use App\Mail\InvoiceDueReminder;
use App\Mail\PaymentReceived;
use App\Models\SalesInvoice;
use App\Models\Approval;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public static function sendInvoiceDueReminder(SalesInvoice $invoice): void
    {
        if ($invoice->customer && $invoice->customer->email) {
            Mail::to($invoice->customer->email)->send(new InvoiceDueReminder($invoice));
        }
    }

    public static function sendPaymentReceived(SalesInvoice $invoice): void
    {
        if ($invoice->customer && $invoice->customer->email) {
            Mail::to($invoice->customer->email)->send(new PaymentReceived($invoice));
        }
    }

    public static function sendApprovalRequest(Approval $approval): void
    {
        $approver = $approval->approvedBy;
        if ($approver && $approver->email) {
            Mail::to($approver->email)->send(new ApprovalRequested($approval));
        }
    }

    public static function sendLowStockAlert(ProductVariant $variant, string $warehouseName, float $onHand): void
    {
        $adminEmail = config('mail.low_stock_alert_to', config('mail.from.address'));
        if ($adminEmail) {
            Mail::to($adminEmail)->send(new \App\Mail\LowStockAlert($variant, $warehouseName, $onHand));
        }
    }

    public static function createInternalNotification(int $userId, string $type, string $title, string $message, ?array $data = null): void
    {
        \App\Models\Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
        ]);
    }
}
