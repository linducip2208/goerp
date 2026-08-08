<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\SalesInvoice;
use App\Models\SalesPayment;

class DashboardController extends Controller
{
    public function index()
    {
        $customerId = session('portal_customer_id');

        $totalInvoices = SalesInvoice::where('customer_id', $customerId)->count();
        $totalSpent = SalesPayment::whereHas('invoice', fn($q) => $q->where('customer_id', $customerId))->sum('amount');
        $outstanding = SalesInvoice::where('customer_id', $customerId)->whereIn('status', ['open', 'partial', 'overdue'])->sum('outstanding');
        $activeOrders = SalesInvoice::where('customer_id', $customerId)->whereIn('status', ['open', 'partial'])->count();
        $paid = SalesInvoice::where('customer_id', $customerId)->where('status', 'paid')->count();

        $recentInvoices = SalesInvoice::where('customer_id', $customerId)
            ->with('currency')
            ->latest()
            ->take(5)
            ->get();

        return view('portal.dashboard', compact('totalInvoices', 'totalSpent', 'outstanding', 'activeOrders', 'paid', 'recentInvoices'));
    }

    public function invoices()
    {
        $invoices = SalesInvoice::where('customer_id', session('portal_customer_id'))
            ->with('items.productVariant', 'payments', 'currency')
            ->latest()
            ->paginate(10);

        return view('portal.invoices', compact('invoices'));
    }

    public function invoiceDetail($id)
    {
        $invoice = SalesInvoice::where('customer_id', session('portal_customer_id'))
            ->with('items.productVariant', 'payments', 'currency')
            ->findOrFail($id);

        return view('portal.invoice-detail', compact('invoice'));
    }

    public function payments()
    {
        $payments = SalesPayment::whereHas('invoice', fn($q) => $q->where('customer_id', session('portal_customer_id')))
            ->with('invoice')
            ->latest()
            ->paginate(10);

        return view('portal.payments', compact('payments'));
    }
}
