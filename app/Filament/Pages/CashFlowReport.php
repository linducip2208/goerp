<?php

namespace App\Filament\Pages;

use App\Models\BankTransaction;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;

class CashFlowReport extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-trending-up';
    protected static ?string $navigationGroup = '📈 Reports';
    protected static ?int $navigationSort = 73;
    protected static ?string $title = 'Arus Kas';

    protected static string $view = 'filament.pages.cash-flow-report';

    public ?array $data = [];
    public array $transactions = [];
    public float $totalIn = 0;
    public float $totalOut = 0;
    public float $netCashFlow = 0;

    public function mount(): void
    {
        $this->form->fill([
            'date_from' => Carbon::now()->startOfMonth()->format('Y-m-d'),
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
        $dateFrom = $this->data['date_from'] ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $dateTo = $this->data['date_to'] ?? Carbon::now()->format('Y-m-d');

        $transactions = BankTransaction::query()
            ->where('tenant_id', $tenantId)
            ->where('company_id', $companyId)
            ->whereBetween('transaction_date', [$dateFrom, $dateTo])
            ->with('bankAccount', 'contact', 'account')
            ->orderBy('transaction_date')
            ->get();

        $this->transactions = $transactions->toArray();
        $this->totalIn = $transactions->where('transaction_type', 'in')->sum('amount');
        $this->totalOut = $transactions->where('transaction_type', 'out')->sum('amount');
        $this->netCashFlow = $this->totalIn - $this->totalOut;
    }
}
