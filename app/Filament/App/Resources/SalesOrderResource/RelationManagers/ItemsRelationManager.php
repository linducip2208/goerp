<?php

namespace App\Filament\App\Resources\SalesOrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Item Sales Order';

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
                Forms\Components\Grid::make(5)
                    ->schema([
                        Forms\Components\TextInput::make('quantity')
                            ->label('Qty')
                            ->numeric()
                            ->default(1)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, Forms\Get $get) => self::calculateTotals($set, $get)),
                        Forms\Components\TextInput::make('delivered_qty')
                            ->label('Qty Terkirim')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
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
                Tables\Columns\TextColumn::make('delivered_qty')
                    ->label('Qty Terkirim')
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
