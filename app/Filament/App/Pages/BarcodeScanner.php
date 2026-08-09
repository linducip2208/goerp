<?php

namespace App\Filament\App\Pages;

use App\Models\ProductVariant;
use App\Models\InventoryBalance;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

class BarcodeScanner extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-qr-code';
    protected static ?string $navigationGroup = null;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?int $navigationSort = 999;
    protected static ?string $title = 'Barcode Scanner';

    protected static string $view = 'filament.pages.barcode-scanner';

    public ?array $data = [];
    public ?array $result = null;

    public function mount(): void
    {
        $this->form->fill([
            'barcode' => '',
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('barcode')
                    ->label('Scan / Masukkan Barcode')
                    ->placeholder('Scan barcode atau ketik manual...')
                    ->autofocus()
                    ->extraInputAttributes(['class' => 'text-lg font-mono'])
                    ->live()
                    ->afterStateUpdated(fn () => $this->scan()),
            ])
            ->statePath('data');
    }

    public function scan(): void
    {
        $barcode = $this->data['barcode'] ?? '';

        if (empty($barcode)) {
            return;
        }

        $variant = ProductVariant::where('barcode', $barcode)
            ->whereHas('product', function ($q) {
                $q->where('tenant_id', auth()->user()->tenant_id);
            })
            ->first();

        if (!$variant) {
            Notification::make()
                ->title('Produk tidak ditemukan')
                ->body("Barcode \"{$barcode}\" tidak terdaftar di sistem.")
                ->danger()
                ->send();
            $this->data['barcode'] = '';
            return;
        }

        $variant->load('product');

        $balances = InventoryBalance::where('product_variant_id', $variant->id)
            ->where('tenant_id', auth()->user()->tenant_id)
            ->with('warehouse')
            ->get();

        $this->result = [
            'variant' => $variant->toArray(),
            'balances' => $balances->map(fn ($b) => [
                'warehouse' => $b->warehouse->name ?? '—',
                'on_hand' => $b->on_hand,
                'reserved' => $b->reserved,
                'available' => $b->available,
            ])->toArray(),
        ];

        $this->data['barcode'] = '';

        Notification::make()
            ->title($variant->name)
            ->body('Produk ditemukan.')
            ->success()
            ->send();
    }
}
