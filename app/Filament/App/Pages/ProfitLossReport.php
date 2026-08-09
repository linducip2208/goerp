<?php

namespace App\Filament\App\Pages;

use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalEntryLine;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class ProfitLossReport extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = '📈 Laporan';
    protected static ?int $navigationSort = 71;
    protected static ?string $title = 'Laba Rugi';

    protected static string $view = 'filament.pages.profit-loss-report';

    public ?array $data = [];
    public array $results = [];
    public array $summary = [];

    public function mount(): void
    {
        $this->form->fill([
            'date_from' => Carbon::now()->startOfYear()->format('Y-m-d'),
            'date_to' => Carbon::now()->format('Y-m-d'),
        ]);

        $this->calculate();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(4)
                    ->schema([
                        DatePicker::make('date_from')
                            ->label('Dari')
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn() => $this->calculate()),
                        DatePicker::make('date_to')
                            ->label('Sampai')
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
        $dateFrom = $this->data['date_from'] ?? Carbon::now()->startOfYear()->format('Y-m-d');
        $dateTo = $this->data['date_to'] ?? Carbon::now()->format('Y-m-d');

        $query = JournalEntryLine::query()
            ->whereHas('journalEntry', function ($q) use ($tenantId, $companyId, $dateFrom, $dateTo) {
                $q->where('tenant_id', $tenantId)
                    ->where('company_id', $companyId)
                    ->where('is_posted', true)
                    ->whereBetween('journal_date', [$dateFrom, $dateTo]);
            })
            ->with('account');

        $lines = $query->get();

        $accounts = Account::where('tenant_id', $tenantId)
            ->where('company_id', $companyId)
            ->where('is_active', true)
            ->get()
            ->keyBy('id');

        $revenueAccounts = ['400', '401', '402', '403', '404', '405', '406', '407', '408', '409', '41', '42', '43', '44'];
        $cogsAccounts = ['500', '501', '502', '503', '504', '505', '506', '507', '508', '509', '51', '52', '53', '54'];
        $expenseAccounts = ['600', '601', '602', '603', '604', '605', '606', '607', '608', '609', '61', '62', '63', '64', '65', '66', '67', '68', '69', '7', '700', '701', '702', '703', '704', '705', '706', '707', '708', '709', '71', '72', '73', '74', '75', '76', '77', '78', '79', '8', '800', '801', '802', '803', '804', '805', '806', '807', '808', '809', '81', '82', '83', '84', '85', '86', '87', '88', '89', '9', '900', '901', '902', '903', '904', '905', '906', '907', '908', '909', '91', '92', '93', '94', '95', '96', '97', '98', '99'];

        $totalRevenue = 0;
        $totalCogs = 0;
        $totalExpense = 0;
        $revenueBreakdown = [];
        $cogsBreakdown = [];
        $expenseBreakdown = [];

        foreach ($lines as $line) {
            $account = $accounts->get($line->account_id);
            if (!$account) {
                continue;
            }

            $code = $account->code;
            $credit = floatval($line->credit ?? 0);
            $debit = floatval($line->debit ?? 0);
            $net = $credit - $debit;

            if ($this->startsWithAny($code, $revenueAccounts)) {
                $totalRevenue += $net;
                $revenueBreakdown[$account->name] = ($revenueBreakdown[$account->name] ?? 0) + $net;
            } elseif ($this->startsWithAny($code, $cogsAccounts)) {
                $totalCogs += -$net;
                $cogsBreakdown[$account->name] = ($cogsBreakdown[$account->name] ?? 0) + $net;
            } elseif ($this->startsWithAny($code, $expenseAccounts)) {
                $totalExpense += -$net;
                $expenseBreakdown[$account->name] = ($expenseBreakdown[$account->name] ?? 0) + -$net;
            }
        }

        $grossProfit = $totalRevenue - $totalCogs;
        $netProfit = $grossProfit - $totalExpense;

        $this->summary = [
            'revenue' => $totalRevenue,
            'cogs' => $totalCogs,
            'gross_profit' => $grossProfit,
            'expense' => $totalExpense,
            'net_profit' => $netProfit,
        ];

        $this->results = [
            'revenue' => $revenueBreakdown,
            'cogs' => $cogsBreakdown,
            'expense' => $expenseBreakdown,
        ];
    }

    private function startsWithAny(string $code, array $prefixes): bool
    {
        foreach ($prefixes as $prefix) {
            if (str_starts_with($code, $prefix)) {
                return true;
            }
        }
        return false;
    }
}
