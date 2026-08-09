<?php

namespace App\Filament\App\Pages;

use App\Models\Account;
use App\Models\JournalEntryLine;
use Filament\Pages\Page;

class TrialBalanceReport extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-scale';
    protected static ?string $navigationGroup = '📈 Laporan';
    protected static ?int $navigationSort = 79;
    protected static ?string $title = 'Neraca Saldo';

    protected static string $view = 'filament.pages.reports.trial-balance';

    public array $accounts = [];
    public float $totalDebit = 0;
    public float $totalCredit = 0;

    public function mount(): void
    {
        $this->loadData();
    }

    protected function loadData(): void
    {
        $accounts = Account::where('is_active', true)
            ->orderBy('code')
            ->get();

        foreach ($accounts as $account) {
            $debit = JournalEntryLine::where('account_id', $account->id)
                ->whereHas('journalEntry', fn($q) => $q->where('status', 'posted'))
                ->sum('debit');

            $credit = JournalEntryLine::where('account_id', $account->id)
                ->whereHas('journalEntry', fn($q) => $q->where('status', 'posted'))
                ->sum('credit');

            $balance = $account->normal_balance === 'debit'
                ? $debit - $credit
                : $credit - $debit;

            if ($debit > 0 || $credit > 0) {
                $this->accounts[] = [
                    'code' => $account->code,
                    'name' => $account->name,
                    'type' => $account->type,
                    'debit' => $debit,
                    'credit' => $credit,
                    'balance' => $balance,
                ];
            }

            $this->totalDebit += $debit;
            $this->totalCredit += $credit;
        }
    }
}
