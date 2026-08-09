<?php

namespace App\Filament\App\Pages;

use App\Models\Account;
use App\Models\Setting;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class AccountingSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';
    protected static ?string $navigationGroup = '⚙️ Pengaturan';
    protected static ?int $navigationSort = 162;
    protected static ?string $title = 'Akuntansi';

    protected static string $view = 'filament.pages.accounting-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $accountOptions = Account::where('tenant_id', auth()->user()->tenant_id)
            ->where('company_id', auth()->user()->company_id)
            ->where('is_active', true)
            ->pluck('name', 'id');

        $this->form->fill([
            'ar_account_id' => Setting::get('ar_account_id'),
            'ap_account_id' => Setting::get('ap_account_id'),
            'sales_account_id' => Setting::get('sales_account_id'),
            'cogs_account_id' => Setting::get('cogs_account_id'),
            'inventory_account_id' => Setting::get('inventory_account_id'),
            'cash_account_id' => Setting::get('cash_account_id'),
            'bank_account_id' => Setting::get('bank_account_id'),
            'tax_account_id' => Setting::get('tax_account_id'),
            'retained_earnings_id' => Setting::get('retained_earnings_id'),
        ]);

        $this->accountOptions = $accountOptions->toArray();
    }

    public array $accountOptions = [];

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        Select::make('ar_account_id')
                            ->label('Akun Piutang Usaha (AR)')
                            ->options($this->accountOptions)
                            ->searchable(),
                        Select::make('ap_account_id')
                            ->label('Akun Hutang Usaha (AP)')
                            ->options($this->accountOptions)
                            ->searchable(),
                        Select::make('sales_account_id')
                            ->label('Akun Penjualan')
                            ->options($this->accountOptions)
                            ->searchable(),
                        Select::make('cogs_account_id')
                            ->label('Akun HPP (COGS)')
                            ->options($this->accountOptions)
                            ->searchable(),
                        Select::make('inventory_account_id')
                            ->label('Akun Persediaan')
                            ->options($this->accountOptions)
                            ->searchable(),
                        Select::make('cash_account_id')
                            ->label('Akun Kas')
                            ->options($this->accountOptions)
                            ->searchable(),
                        Select::make('bank_account_id')
                            ->label('Akun Bank')
                            ->options($this->accountOptions)
                            ->searchable(),
                        Select::make('tax_account_id')
                            ->label('Akun Pajak')
                            ->options($this->accountOptions)
                            ->searchable(),
                        Select::make('retained_earnings_id')
                            ->label('Akun Laba Ditahan')
                            ->options($this->accountOptions)
                            ->searchable(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        Setting::set('ar_account_id', $data['ar_account_id'] ?? null);
        Setting::set('ap_account_id', $data['ap_account_id'] ?? null);
        Setting::set('sales_account_id', $data['sales_account_id'] ?? null);
        Setting::set('cogs_account_id', $data['cogs_account_id'] ?? null);
        Setting::set('inventory_account_id', $data['inventory_account_id'] ?? null);
        Setting::set('cash_account_id', $data['cash_account_id'] ?? null);
        Setting::set('bank_account_id', $data['bank_account_id'] ?? null);
        Setting::set('tax_account_id', $data['tax_account_id'] ?? null);
        Setting::set('retained_earnings_id', $data['retained_earnings_id'] ?? null);

        Notification::make()
            ->title('Pengaturan akuntansi berhasil disimpan')
            ->success()
            ->send();
    }
}
