<?php

namespace App\Filament\App\Pages;

use App\Models\Account;
use App\Models\JournalEntryLine;
use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;

class GeneralLedger extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = '📈 Laporan';
    protected static ?int $navigationSort = 20;
    protected static ?string $title = 'General Ledger';
    protected static ?string $navigationLabel = 'General Ledger';
    protected static string $view = 'filament.pages.general-ledger';

    public ?int $account_id = null;
    public ?string $start_date = null;
    public ?string $end_date = null;
    public array $entries = [];
    public ?float $openingBalance = 0;
    public ?float $closingBalance = 0;

    public function mount(): void
    {
        $this->start_date = now()->startOfMonth()->format('Y-m-d');
        $this->end_date = now()->format('Y-m-d');
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('account_id')
                ->label('Akun')
                ->options(Account::pluck('name', 'id'))
                ->searchable()
                ->required()
                ->live(),
            Forms\Components\DatePicker::make('start_date')->label('Dari'),
            Forms\Components\DatePicker::make('end_date')->label('Sampai'),
        ];
    }

    public function load(): void
    {
        $query = JournalEntryLine::whereHas('journalEntry', function ($q) {
            $q->where('is_posted', true);
        })->where('account_id', $this->account_id);

        if ($this->start_date) {
            $query->whereHas('journalEntry', fn($q) => $q->where('journal_date', '>=', $this->start_date));
        }
        if ($this->end_date) {
            $query->whereHas('journalEntry', fn($q) => $q->where('journal_date', '<=', $this->end_date));
        }

        $lines = $query->with('journalEntry')->get();

        $opening = JournalEntryLine::whereHas('journalEntry', function ($q) {
            $q->where('is_posted', true)->where('journal_date', '<', $this->start_date);
        })->where('account_id', $this->account_id)->get();
        $this->openingBalance = $opening->sum('debit') - $opening->sum('credit');

        $this->entries = $lines->map(function ($line) {
            return [
                'date' => $line->journalEntry->journal_date->format('d/m/Y'),
                'journal_no' => $line->journalEntry->journal_no,
                'description' => $line->description ?? $line->journalEntry->description,
                'debit' => (float) $line->debit,
                'credit' => (float) $line->credit,
            ];
        })->toArray();

        $this->closingBalance = $this->openingBalance + $lines->sum('debit') - $lines->sum('credit');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }
}
