<?php

namespace App\Filament\Pages;

use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalEntryLine;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class PeriodClosing extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-check-badge';
    protected static ?string $navigationGroup = '📊 Akuntansi';
    protected static ?int $navigationSort = 55;
    protected static ?string $title = 'Tutup Buku';
    protected static ?string $navigationLabel = 'Tutup Buku';
    protected static string $view = 'filament.pages.period-closing';

    public ?string $period = null;

    public bool $bankReconciled = false;
    public bool $stockOpnameDone = false;
    public bool $depreciationDone = false;
    public bool $trialBalanceDone = false;
    public ?string $closingResult = null;

    public function mount(): void
    {
        $this->period = now()->startOfMonth()->format('Y-m');
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('period')
                ->label('Periode')
                ->options(function () {
                    $periods = [];
                    for ($i = 0; $i < 12; $i++) {
                        $d = now()->subMonths($i)->startOfMonth();
                        $periods[$d->format('Y-m')] = $d->translatedFormat('F Y');
                    }
                    return $periods;
                })
                ->required()
                ->live(),
        ];
    }

    public function closePeriod(): void
    {
        if (!$this->bankReconciled || !$this->stockOpnameDone || !$this->depreciationDone || !$this->trialBalanceDone) {
            Notification::make()
                ->title('Harap selesaikan semua checklist sebelum tutup buku')
                ->warning()
                ->send();
            return;
        }

        $revenueAccount = Account::where('category', 'revenue')->first();
        $cogsAccount = Account::where('category', 'cogs')->first();
        $expenseAccounts = Account::whereIn('category', ['expense', 'other_expense'])->get();
        $otherIncomeAccounts = Account::where('category', 'other_income')->get();
        $retainedEarnings = Account::where('category', 'equity')->where('code', 'like', '3-%')->first();

        $startDate = $this->period . '-01';
        $endDate = date('Y-m-t', strtotime($startDate));

        $revenueTotal = JournalEntryLine::whereHas('journalEntry', function ($q) use ($startDate, $endDate) {
            $q->where('is_posted', true)
                ->whereBetween('journal_date', [$startDate, $endDate]);
        })->when($revenueAccount, fn($q) => $q->where('account_id', $revenueAccount->id))
          ->sum('credit') - JournalEntryLine::whereHas('journalEntry', function ($q) use ($startDate, $endDate) {
              $q->where('is_posted', true)
                  ->whereBetween('journal_date', [$startDate, $endDate]);
          })->when($revenueAccount, fn($q) => $q->where('account_id', $revenueAccount->id))->sum('debit');

        $cogsTotal = JournalEntryLine::whereHas('journalEntry', function ($q) use ($startDate, $endDate) {
            $q->where('is_posted', true)
                ->whereBetween('journal_date', [$startDate, $endDate]);
        })->when($cogsAccount, fn($q) => $q->where('account_id', $cogsAccount->id))
          ->sum('debit');

        $expenseTotal = JournalEntryLine::whereHas('journalEntry', function ($q) use ($startDate, $endDate) {
            $q->where('is_posted', true)
                ->whereBetween('journal_date', [$startDate, $endDate]);
        })->whereIn('account_id', $expenseAccounts->pluck('id'))
          ->sum('debit');

        $otherIncomeTotal = JournalEntryLine::whereHas('journalEntry', function ($q) use ($startDate, $endDate) {
            $q->where('is_posted', true)
                ->whereBetween('journal_date', [$startDate, $endDate]);
        })->whereIn('account_id', $otherIncomeAccounts->pluck('id'))
          ->sum('credit');

        $netIncome = $revenueTotal + $otherIncomeTotal - $cogsTotal - $expenseTotal;

        $journalNo = 'CLS/' . str_replace('-', '', $this->period) . '/' . str_pad((string) (JournalEntry::where('journal_no', 'like', 'CLS/%')->count() + 1), 4, '0', STR_PAD_LEFT);

        $journal = JournalEntry::create([
            'tenant_id' => auth()->user()?->tenant_id,
            'company_id' => auth()->user()?->company_id,
            'journal_no' => $journalNo,
            'journal_date' => $endDate,
            'source_type' => null,
            'source_id' => null,
            'reference' => null,
            'description' => 'Jurnal Penutup - Periode ' . $this->period,
            'is_posted' => true,
            'posted_by' => auth()->id(),
            'posted_at' => now(),
            'period' => $this->period,
            'created_by' => auth()->id(),
        ]);

        $lines = [];
        $totalDebit = 0;
        $totalCredit = 0;

        if ($revenueTotal > 0 && $revenueAccount) {
            $lines[] = ['account_id' => $revenueAccount->id, 'debit' => $revenueTotal, 'credit' => 0, 'description' => 'Tutup Pendapatan'];
            $totalDebit += $revenueTotal;
        }

        if ($otherIncomeTotal > 0) {
            foreach ($otherIncomeAccounts as $acc) {
                $amt = JournalEntryLine::whereHas('journalEntry', function ($q) use ($startDate, $endDate) {
                    $q->where('is_posted', true)->whereBetween('journal_date', [$startDate, $endDate]);
                })->where('account_id', $acc->id)->sum('credit');
                if ($amt > 0) {
                    $lines[] = ['account_id' => $acc->id, 'debit' => $amt, 'credit' => 0, 'description' => 'Tutup Pendapatan Lain - ' . $acc->name];
                    $totalDebit += $amt;
                }
            }
        }

        if ($cogsTotal > 0 && $cogsAccount) {
            $lines[] = ['account_id' => $cogsAccount->id, 'debit' => 0, 'credit' => $cogsTotal, 'description' => 'Tutup HPP'];
            $totalCredit += $cogsTotal;
        }

        foreach ($expenseAccounts as $expAcc) {
            $amt = JournalEntryLine::whereHas('journalEntry', function ($q) use ($startDate, $endDate) {
                $q->where('is_posted', true)->whereBetween('journal_date', [$startDate, $endDate]);
            })->where('account_id', $expAcc->id)->sum('debit');
            if ($amt > 0) {
                $lines[] = ['account_id' => $expAcc->id, 'debit' => 0, 'credit' => $amt, 'description' => 'Tutup Biaya - ' . $expAcc->name];
                $totalCredit += $amt;
            }
        }

        $closeEquityLine = ['account_id' => $retainedEarnings->id ?? $revenueAccount->id, 'debit' => 0, 'credit' => 0, 'description' => 'Laba/Rugi Ditahan - Periode ' . $this->period];

        if ($netIncome >= 0) {
            $closeEquityLine['credit'] = abs($netIncome);
            $totalCredit += abs($netIncome);
        } else {
            $closeEquityLine['debit'] = abs($netIncome);
            $totalDebit += abs($netIncome);
        }

        $lines[] = $closeEquityLine;

        foreach ($lines as $line) {
            JournalEntryLine::create([
                'journal_entry_id' => $journal->id,
                'account_id' => $line['account_id'],
                'debit' => $line['debit'] ?? 0,
                'credit' => $line['credit'] ?? 0,
                'description' => $line['description'],
            ]);
        }

        $journal->update([
            'total_debit' => $totalDebit,
            'total_credit' => $totalCredit,
        ]);

        $this->closingResult = 'Periode ' . $this->period . ' berhasil ditutup. Jurnal penutup: ' . $journalNo;

        Notification::make()
            ->title('Tutup Buku Berhasil')
            ->body($this->closingResult)
            ->success()
            ->send();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }
}
