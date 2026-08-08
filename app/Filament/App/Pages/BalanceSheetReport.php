<?php

namespace App\Filament\App\Pages;

use App\Models\Account;
use App\Models\JournalEntryLine;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;

class BalanceSheetReport extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';
    protected static ?string $navigationGroup = '📈 Reports';
    protected static ?int $navigationSort = 72;
    protected static ?string $title = 'Neraca';

    protected static string $view = 'filament.pages.balance-sheet-report';

    public ?array $data = [];
    public array $assets = [];
    public array $liabilities = [];
    public array $equity = [];
    public float $totalAssets = 0;
    public float $totalLiabilities = 0;
    public float $totalEquity = 0;

    public function mount(): void
    {
        $this->form->fill([
            'as_of_date' => Carbon::now()->format('Y-m-d'),
        ]);

        $this->calculate();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(4)
                    ->schema([
                        DatePicker::make('as_of_date')
                            ->label('Per Tanggal')
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn() => $this->calculate()),
                    ]),
            ])
            ->statePath('data');
    }

    public function calculate(): void
    {
        $tenantId = auth()->user()->tenant_id;
        $companyId = auth()->user()->company_id;
        $asOfDate = $this->data['as_of_date'] ?? Carbon::now()->format('Y-m-d');

        $accounts = Account::where('tenant_id', $tenantId)
            ->where('company_id', $companyId)
            ->where('is_active', true)
            ->get()
            ->keyBy('id');

        $lines = JournalEntryLine::query()
            ->whereHas('journalEntry', function ($q) use ($tenantId, $companyId, $asOfDate) {
                $q->where('tenant_id', $tenantId)
                    ->where('company_id', $companyId)
                    ->where('is_posted', true)
                    ->where('journal_date', '<=', $asOfDate);
            })
            ->with('account')
            ->get();

        $this->assets = [];
        $this->liabilities = [];
        $this->equity = [];
        $this->totalAssets = 0;
        $this->totalLiabilities = 0;
        $this->totalEquity = 0;

        foreach ($lines as $line) {
            $account = $accounts->get($line->account_id);
            if (!$account) {
                continue;
            }

            $code = $account->code;
            $debit = floatval($line->debit ?? 0);
            $credit = floatval($line->credit ?? 0);
            $balance = $debit - $credit;

            if (str_starts_with($code, '1')) {
                $this->assets[$account->name] = ($this->assets[$account->name] ?? 0) + $balance;
                $this->totalAssets += $balance;
            } elseif (str_starts_with($code, '2')) {
                $this->liabilities[$account->name] = ($this->liabilities[$account->name] ?? 0) + $balance;
                $this->totalLiabilities += $balance;
            } elseif (str_starts_with($code, '3')) {
                $this->equity[$account->name] = ($this->equity[$account->name] ?? 0) + $balance;
                $this->totalEquity += $balance;
            }
        }

        foreach ($accounts as $account) {
            if (str_starts_with($account->code, '1') && floatval($account->opening_balance) > 0) {
                $this->assets[$account->name] = ($this->assets[$account->name] ?? 0) + floatval($account->opening_balance);
                $this->totalAssets += floatval($account->opening_balance);
            } elseif (str_starts_with($account->code, '3') && floatval($account->opening_balance) > 0) {
                $this->equity[$account->name] = ($this->equity[$account->name] ?? 0) + floatval($account->opening_balance);
                $this->totalEquity += floatval($account->opening_balance);
            }
        }
    }
}
