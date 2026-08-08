<?php

namespace App\Services\Accounting;

use App\Models\Account;
use App\Models\Expense;
use App\Models\JournalEntry;
use App\Models\JournalEntryLine;
use App\Models\PurchaseInvoice;
use App\Models\PurchasePayment;
use App\Models\SalesInvoice;
use App\Models\SalesPayment;

class JournalService
{
    protected static function generateJournalNo(): string
    {
        $now = now();
        $year = $now->format('Y');
        $month = $now->format('m');
        $prefix = "JE/{$year}/{$month}/";

        $last = JournalEntry::where('journal_no', 'like', $prefix . '%')
            ->orderBy('journal_no', 'desc')
            ->first();

        if ($last) {
            $lastNum = (int) substr($last->journal_no, -4);
            $nextNum = $lastNum + 1;
        } else {
            $nextNum = 1;
        }

        return $prefix . str_pad((string) $nextNum, 4, '0', STR_PAD_LEFT);
    }

    public static function postSalesInvoice(SalesInvoice $invoice): JournalEntry
    {
        $arAccount = Account::where('category', 'asset')->where('code', 'like', '1-2%')->first();
        $revenueAccount = Account::where('category', 'revenue')->first();
        $cogsAccount = Account::where('category', 'cogs')->first();
        $inventoryAccount = Account::where('category', 'asset')->where('code', 'like', '1-3%')->first();

        $journal = JournalEntry::create([
            'tenant_id' => $invoice->tenant_id,
            'company_id' => $invoice->company_id,
            'journal_no' => static::generateJournalNo(),
            'journal_date' => $invoice->invoice_date,
            'source_type' => SalesInvoice::class,
            'source_id' => $invoice->id,
            'reference' => $invoice->invoice_no,
            'description' => 'Penjualan - ' . $invoice->invoice_no,
            'total_debit' => 0,
            'total_credit' => 0,
            'period' => $invoice->invoice_date->format('Y-m'),
        ]);

        $lines = [];

        if ($arAccount) {
            $lines[] = ['journal_entry_id' => $journal->id, 'account_id' => $arAccount->id, 'debit' => $invoice->grand_total, 'credit' => 0, 'description' => 'Piutang - ' . $invoice->invoice_no, 'contact_id' => $invoice->customer_id];
        }
        if ($revenueAccount) {
            $lines[] = ['journal_entry_id' => $journal->id, 'account_id' => $revenueAccount->id, 'debit' => 0, 'credit' => $invoice->subtotal, 'description' => 'Penjualan - ' . $invoice->invoice_no];
        }

        $cogsTotal = $invoice->items->sum('total');
        if ($cogsTotal > 0) {
            if ($cogsAccount) {
                $lines[] = ['journal_entry_id' => $journal->id, 'account_id' => $cogsAccount->id, 'debit' => $cogsTotal, 'credit' => 0, 'description' => 'HPP - ' . $invoice->invoice_no];
            }
            if ($inventoryAccount) {
                $lines[] = ['journal_entry_id' => $journal->id, 'account_id' => $inventoryAccount->id, 'debit' => 0, 'credit' => $cogsTotal, 'description' => 'Persediaan - ' . $invoice->invoice_no];
            }
        }

        foreach ($lines as $line) {
            JournalEntryLine::create($line);
        }

        $totalDebit = collect($lines)->sum('debit');
        $totalCredit = collect($lines)->sum('credit');

        $journal->update([
            'is_posted' => true,
            'posted_at' => now(),
            'total_debit' => $totalDebit,
            'total_credit' => $totalCredit,
        ]);

        $invoice->update(['posted_at' => now()]);

        return $journal;
    }

    public static function postPurchaseInvoice(PurchaseInvoice $invoice): JournalEntry
    {
        $expenseAccount = Account::where('category', 'expense')->first();
        $inventoryAccount = Account::where('category', 'asset')->where('code', 'like', '1-3%')->first();
        $apAccount = Account::where('category', 'liability')->where('code', 'like', '2-1%')->first();

        $journal = JournalEntry::create([
            'tenant_id' => $invoice->tenant_id,
            'company_id' => $invoice->company_id,
            'journal_no' => static::generateJournalNo(),
            'journal_date' => $invoice->invoice_date,
            'source_type' => PurchaseInvoice::class,
            'source_id' => $invoice->id,
            'reference' => $invoice->invoice_supplier_no,
            'description' => 'Pembelian - ' . $invoice->invoice_supplier_no,
            'total_debit' => 0,
            'total_credit' => 0,
            'period' => $invoice->invoice_date->format('Y-m'),
        ]);

        $lines = [];

        if ($inventoryAccount) {
            $lines[] = ['journal_entry_id' => $journal->id, 'account_id' => $inventoryAccount->id, 'debit' => $invoice->subtotal, 'credit' => 0, 'description' => 'Pembelian - ' . $invoice->invoice_supplier_no];
        } elseif ($expenseAccount) {
            $lines[] = ['journal_entry_id' => $journal->id, 'account_id' => $expenseAccount->id, 'debit' => $invoice->subtotal, 'credit' => 0, 'description' => 'Pembelian - ' . $invoice->invoice_supplier_no];
        }

        if ($apAccount) {
            $lines[] = ['journal_entry_id' => $journal->id, 'account_id' => $apAccount->id, 'debit' => 0, 'credit' => $invoice->grand_total, 'description' => 'Hutang - ' . $invoice->invoice_supplier_no, 'contact_id' => $invoice->supplier_id];
        }

        foreach ($lines as $line) {
            JournalEntryLine::create($line);
        }

        $totalDebit = collect($lines)->sum('debit');
        $totalCredit = collect($lines)->sum('credit');

        $journal->update([
            'is_posted' => true,
            'posted_at' => now(),
            'total_debit' => $totalDebit,
            'total_credit' => $totalCredit,
        ]);

        $invoice->update(['posted_at' => now()]);

        return $journal;
    }

    public static function postPayment(SalesPayment $payment): JournalEntry
    {
        $invoice = $payment->invoice;
        $cashAccount = Account::where('category', 'asset')->where('code', 'like', '1-1%')->first();
        $arAccount = Account::where('category', 'asset')->where('code', 'like', '1-2%')->first();

        $journal = JournalEntry::create([
            'tenant_id' => $payment->tenant_id,
            'company_id' => $payment->company_id,
            'journal_no' => static::generateJournalNo(),
            'journal_date' => $payment->payment_date,
            'source_type' => SalesPayment::class,
            'source_id' => $payment->id,
            'reference' => $payment->payment_no,
            'description' => 'Pembayaran - ' . $payment->payment_no,
            'total_debit' => 0,
            'total_credit' => 0,
            'period' => $payment->payment_date->format('Y-m'),
        ]);

        $lines = [];

        if ($cashAccount) {
            $lines[] = ['journal_entry_id' => $journal->id, 'account_id' => $cashAccount->id, 'debit' => $payment->amount, 'credit' => 0, 'description' => 'Kas - ' . $payment->payment_no];
        }
        if ($arAccount) {
            $lines[] = ['journal_entry_id' => $journal->id, 'account_id' => $arAccount->id, 'debit' => 0, 'credit' => $payment->amount, 'description' => 'Piutang - ' . ($invoice->invoice_no ?? ''), 'contact_id' => $invoice->customer_id ?? null];
        }

        foreach ($lines as $line) {
            JournalEntryLine::create($line);
        }

        $totalDebit = collect($lines)->sum('debit');
        $totalCredit = collect($lines)->sum('credit');

        $journal->update([
            'is_posted' => true,
            'posted_at' => now(),
            'total_debit' => $totalDebit,
            'total_credit' => $totalCredit,
        ]);

        $payment->update(['posted_at' => now()]);

        return $journal;
    }

    public static function postExpense(Expense $expense): JournalEntry
    {
        $cashAccount = Account::where('category', 'asset')->where('code', 'like', '1-1%')->first();
        $apAccount = Account::where('category', 'liability')->where('code', 'like', '2-1%')->first();

        $journal = JournalEntry::create([
            'tenant_id' => $expense->tenant_id,
            'company_id' => $expense->company_id,
            'journal_no' => static::generateJournalNo(),
            'journal_date' => $expense->expense_date,
            'source_type' => Expense::class,
            'source_id' => $expense->id,
            'reference' => $expense->expense_no,
            'description' => 'Biaya - ' . $expense->expense_no . ' - ' . ($expense->payee ?? ''),
            'total_debit' => 0,
            'total_credit' => 0,
            'period' => $expense->expense_date->format('Y-m'),
        ]);

        $lines = [];

        $lines[] = ['journal_entry_id' => $journal->id, 'account_id' => $expense->account_id, 'debit' => $expense->amount, 'credit' => 0, 'description' => 'Biaya - ' . ($expense->memo ?? $expense->payee)];

        if ($cashAccount) {
            $lines[] = ['journal_entry_id' => $journal->id, 'account_id' => $cashAccount->id, 'debit' => 0, 'credit' => $expense->amount, 'description' => 'Kas - ' . $expense->expense_no];
        } elseif ($apAccount) {
            $lines[] = ['journal_entry_id' => $journal->id, 'account_id' => $apAccount->id, 'debit' => 0, 'credit' => $expense->amount, 'description' => 'Hutang - ' . $expense->expense_no];
        }

        foreach ($lines as $line) {
            JournalEntryLine::create($line);
        }

        $totalDebit = collect($lines)->sum('debit');
        $totalCredit = collect($lines)->sum('credit');

        $journal->update([
            'is_posted' => true,
            'posted_at' => now(),
            'total_debit' => $totalDebit,
            'total_credit' => $totalCredit,
        ]);

        return $journal;
    }
}
