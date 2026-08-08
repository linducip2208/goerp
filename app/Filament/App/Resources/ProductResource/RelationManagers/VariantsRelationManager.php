<?php

namespace App\Filament\App\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VariantsRelationManager extends RelationManager
{
    protected static string $relationship = 'variants';

    protected static ?string $title = 'Varian Produk';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('internal_sku')
                    ->label('SKU Internal')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Varian')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('barcode')
                    ->label('Barcode')
                    ->maxLength(255),
                Forms\Components\KeyValue::make('variant_attributes')
                    ->label('Atribut Varian')
                    ->keyLabel('Atribut')
                    ->valueLabel('Nilai')
                    ->addButtonLabel('Tambah Atribut'),
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\TextInput::make('purchase_price')
                            ->label('Harga Beli')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0),
                        Forms\Components\TextInput::make('selling_price')
                            ->label('Harga Jual')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0),
                        Forms\Components\TextInput::make('min_stock')
                            ->label('Min. Stok')
                            ->numeric()
                            ->default(0),
                    ]),
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('reorder_point')
                            ->label('Titik Pesan Ulang')
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('weight')
                            ->label('Berat (kg)')
                            ->numeric()
                            ->default(0),
                    ]),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('internal_sku')
                    ->label('SKU Internal')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Varian')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('barcode')
                    ->label('Barcode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('purchase_price')
                    ->label('Harga Beli')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('selling_price')
                    ->label('Harga Jual')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('min_stock')
                    ->label('Min. Stok')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Varian'),
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
