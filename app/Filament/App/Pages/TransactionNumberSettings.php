<?php

namespace App\Filament\App\Pages;

use App\Models\Setting;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class TransactionNumberSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-hashtag';
    protected static ?string $navigationGroup = '⚙️ Settings';
    protected static ?int $navigationSort = 83;
    protected static ?string $title = 'Nomor Transaksi';

    protected static string $view = 'filament.pages.transaction-number-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'invoice_format' => Setting::get('invoice_format', 'INV/{YYYY}/{MM}/{####}'),
            'po_format' => Setting::get('po_format', 'PO/{YYYY}/{####}'),
            'purchase_invoice_format' => Setting::get('purchase_invoice_format', 'PI/{YYYY}/{MM}/{####}'),
            'sales_order_format' => Setting::get('sales_order_format', 'SO/{YYYY}/{MM}/{####}'),
            'journal_format' => Setting::get('journal_format', 'JV/{YYYY}/{MM}/{####}'),
            'expense_format' => Setting::get('expense_format', 'EXP/{YYYY}/{MM}/{####}'),
            'payment_in_format' => Setting::get('payment_in_format', 'PIN/{YYYY}/{MM}/{####}'),
            'payment_out_format' => Setting::get('payment_out_format', 'POUT/{YYYY}/{MM}/{####}'),
            'material_request_format' => Setting::get('material_request_format', 'MR/{YYYY}/{MM}/{####}'),
            'production_order_format' => Setting::get('production_order_format', 'PROD/{YYYY}/{MM}/{####}'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        TextInput::make('invoice_format')
                            ->label('Faktur Penjualan')
                            ->helperText('{YYYY}=Tahun, {YY}=2digit, {MM}=Bulan, {DD}=Tanggal, {####}=Auto-increment')
                            ->maxLength(255),
                        TextInput::make('po_format')
                            ->label('Purchase Order')
                            ->maxLength(255),
                        TextInput::make('purchase_invoice_format')
                            ->label('Faktur Pembelian')
                            ->maxLength(255),
                        TextInput::make('sales_order_format')
                            ->label('Sales Order')
                            ->maxLength(255),
                        TextInput::make('journal_format')
                            ->label('Jurnal')
                            ->maxLength(255),
                        TextInput::make('expense_format')
                            ->label('Biaya')
                            ->maxLength(255),
                        TextInput::make('payment_in_format')
                            ->label('Pembayaran Masuk')
                            ->maxLength(255),
                        TextInput::make('payment_out_format')
                            ->label('Pembayaran Keluar')
                            ->maxLength(255),
                        TextInput::make('material_request_format')
                            ->label('Permintaan Material')
                            ->maxLength(255),
                        TextInput::make('production_order_format')
                            ->label('Production Order')
                            ->maxLength(255),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        Notification::make()
            ->title('Format nomor transaksi berhasil disimpan')
            ->success()
            ->send();
    }
}
