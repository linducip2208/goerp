<?php

namespace App\Filament\Resources\SalesInvoiceResource\RelationManagers;

use App\Models\ProductVariant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Item Faktur';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_variant_id')
                    ->label('Produk')
                    ->relationship('productVariant', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('description')
                    ->label('Deskripsi')
                    ->maxLength(255),
                Forms\Components\Grid::make(4)
                    ->schema([
                        Forms\Components\TextInput::make('quantity')
                            ->label('Qty')
                            ->numeric()
                            ->default(1)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, Forms\Get $get) => self::calculateTotals($set, $get)),
                        Forms\Components\TextInput::make('unit_price')
                            ->label('Harga Satuan')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, Forms\Get $get) => self::calculateTotals($set, $get)),
                        Forms\Components\TextInput::make('discount_percent')
                            ->label('Diskon %')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, Forms\Get $get) => self::calculateTotals($set, $get)),
                        Forms\Components\TextInput::make('tax_percent')
                            ->label('Pajak %')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, Forms\Get $get) => self::calculateTotals($set, $get)),
                    ]),
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\TextInput::make('subtotal')
                            ->label('Subtotal')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled()
                            ->dehydrated(true),
                        Forms\Components\TextInput::make('discount_amount')
                            ->label('Jumlah Diskon')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled()
                            ->dehydrated(true),
                        Forms\Components\TextInput::make('total')
                            ->label('Total')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled()
                            ->dehydrated(true),
                    ]),
            ]);
    }

    public static function calculateTotals(Forms\Set $set, Forms\Get $get): void
    {
        $qty = (float) ($get('quantity') ?? 0);
        $price = (float) ($get('unit_price') ?? 0);
        $discPct = (float) ($get('discount_percent') ?? 0);
        $taxPct = (float) ($get('tax_percent') ?? 0);

        $subtotal = $qty * $price;
        $discAmount = $subtotal * $discPct / 100;
        $afterDisc = $subtotal - $discAmount;
        $taxAmount = $afterDisc * $taxPct / 100;
        $total = $afterDisc + $taxAmount;

        $set('subtotal', round($subtotal, 2));
        $set('discount_amount', round($discAmount, 2));
        $set('total', round($total, 2));
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                Tables\Columns\TextColumn::make('productVariant.name')
                    ->label('Produk')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Qty')
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit_price')
                    ->label('Harga Satuan')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_percent')
                    ->label('Diskon %')
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tax_percent')
                    ->label('Pajak %')
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make('scan_barcode')
                    ->label('Scan Barcode')
                    ->icon('heroicon-o-qr-code')
                    ->color('gray')
                    ->form([
                        Forms\Components\TextInput::make('barcode')
                            ->label('Barcode')
                            ->placeholder('Scan atau ketik barcode...')
                            ->autofocus()
                            ->extraInputAttributes(['class' => 'text-lg font-mono'])
                            ->required(),
                    ])
                    ->action(function (array $data): void {
                        $tenantId = auth()->user()->tenant_id;
                        $variant = ProductVariant::where('barcode', $data['barcode'])
                            ->whereHas('product', fn ($q) => $q->where('tenant_id', $tenantId))
                            ->first();

                        if (!$variant) {
                            Notification::make()
                                ->title('Produk tidak ditemukan')
                                ->body("Barcode \"{$data['barcode']}\" tidak terdaftar.")
                                ->danger()
                                ->send();
                            return;
                        }

                        $existingItem = $this->getOwnerRecord()->items()
                            ->where('product_variant_id', $variant->id)
                            ->first();

                        if ($existingItem) {
                            $existingItem->increment('quantity');
                            $existingItem->refresh();
                            $qty = (float) ($existingItem->quantity ?? 1);
                            $price = (float) ($existingItem->unit_price ?? 0);
                            $existingItem->update([
                                'subtotal' => $qty * $price,
                                'total' => $qty * $price,
                            ]);
                            Notification::make()
                                ->title('Qty bertambah')
                                ->body("{$variant->name}: qty +1 (sekarang: {$existingItem->quantity})")
                                ->success()
                                ->send();
                        } else {
                            $price = $variant->selling_price ?? 0;
                            $this->getOwnerRecord()->items()->create([
                                'product_variant_id' => $variant->id,
                                'description' => $variant->name,
                                'quantity' => 1,
                                'unit_price' => $price,
                                'subtotal' => $price,
                                'total' => $price,
                            ]);

                            Notification::make()
                                ->title('Item ditambahkan')
                                ->body("{$variant->name} — Rp " . number_format($price, 0, ',', '.'))
                                ->success()
                                ->send();
                        }
                    })
                    ->modalHeading('Scan Barcode')
                    ->modalDescription('Scan barcode produk untuk langsung menambahkan ke faktur.'),
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Item'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
