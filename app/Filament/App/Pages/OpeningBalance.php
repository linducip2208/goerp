<?php

namespace App\Filament\App\Pages;

use App\Models\Account;
use App\Models\JournalEntry;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class OpeningBalance extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-start-on-rectangle';
    protected static ?string $navigationGroup = '⚙️ Pengaturan';
    protected static ?int $navigationSort = 168;
    protected static ?string $title = 'Saldo Awal';

    protected static string $view = 'filament.pages.opening-balance';

    public ?array $data = [];
    public array $accountEntries = [];
    public array $accountCategories = [];

    public function mount(): void
    {
        $this->form->fill([
            'balance_date' => Carbon::now()->startOfYear()->format('Y-m-d'),
        ]);

        $this->loadAccounts();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('balance_date')
                    ->label('Tanggal Saldo Awal')
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn() => $this->loadAccounts()),
            ])
            ->statePath('data');
    }

    public function loadAccounts(): void
    {
        $tenantId = auth()->user()->tenant_id;
        $companyId = auth()->user()->company_id;

        $accounts = Account::where('tenant_id', $tenantId)
            ->where('company_id', $companyId)
            ->where('is_active', true)
            ->whereNotNull('category')
            ->orderBy('code')
            ->get();

        $this->accountCategories = $accounts->pluck('category')->unique()->values()->toArray();
        $this->accountEntries = $accounts->map(fn($a) => [
            'id' => $a->id,
            'code' => $a->code,
            'name' => $a->name,
            'category' => $a->category,
            'debit' => 0,
            'credit' => 0,
        ])->toArray();
    }

    public function save(): void
    {
        $tenantId = auth()->user()->tenant_id;
        $companyId = auth()->user()->company_id;
        $userId = auth()->id();
        $date = $this->data['balance_date'] ?? Carbon::now()->startOfYear()->format('Y-m-d');

        $activeEntries = array_filter($this->accountEntries, fn($e) => floatval($e['debit'] ?? 0) > 0 || floatval($e['credit'] ?? 0) > 0);

        if (empty($activeEntries)) {
            Notification::make()
                ->title('Tidak ada data saldo awal')
                ->warning()
                ->send();
            return;
        }

        $totalDebit = array_sum(array_map(fn($e) => floatval($e['debit'] ?? 0), $activeEntries));
        $totalCredit = array_sum(array_map(fn($e) => floatval($e['credit'] ?? 0), $activeEntries));

        if (abs($totalDebit - $totalCredit) > 0.01) {
            Notification::make()
                ->title('Jurnal tidak seimbang')
                ->body('Total Debit: ' . number_format($totalDebit, 2) . ' | Total Kredit: ' . number_format($totalCredit, 2))
                ->danger()
                ->send();
            return;
        }

        $journal = JournalEntry::create([
            'tenant_id' => $tenantId,
            'company_id' => $companyId,
            'journal_no' => 'SA-' . date('Ymd', strtotime($date)),
            'journal_date' => $date,
            'source_type' => 'opening_balance',
            'reference' => 'Saldo Awal per ' . $date,
            'description' => 'Pencatatan saldo awal akun per ' . $date,
            'total_debit' => $totalDebit,
            'total_credit' => $totalCredit,
            'is_posted' => true,
            'posted_by' => $userId,
            'posted_at' => now(),
            'created_by' => $userId,
        ]);

        foreach ($activeEntries as $entry) {
            $journal->lines()->create([
                'account_id' => $entry['id'],
                'description' => 'Saldo awal ' . $entry['name'],
                'debit' => floatval($entry['debit'] ?? 0),
                'credit' => floatval($entry['credit'] ?? 0),
            ]);
        }

        Notification::make()
            ->title('Saldo awal berhasil disimpan')
            ->body('Total Debit: Rp ' . number_format($totalDebit, 2) . ' | Total Kredit: Rp ' . number_format($totalCredit, 2))
            ->success()
            ->send();

        $this->loadAccounts();
    }
}
