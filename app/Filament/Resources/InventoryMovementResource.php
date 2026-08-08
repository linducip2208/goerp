<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryMovementResource\Pages;
use App\Models\InventoryMovement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InventoryMovementResource extends Resource
{
    protected static ?string $model = InventoryMovement::class;

    protected static ?string $navigationGroup = '📦 Master Data';
    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';
    protected static ?int $navigationSort = 16;
    protected static ?string $modelLabel = 'Mutasi Stok';
    protected static ?string $pluralModelLabel = 'Mutasi Stok';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Select::make('product_variant_id')
                    ->relationship('productVariant', 'name')
                    ->searchable()
                    ->required()
                    ->label('Varian Produk'),
                Forms\Components\Select::make('warehouse_id')
                    ->relationship('warehouse', 'name')
                    ->searchable()
                    ->required()
                    ->label('Gudang'),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->label('User'),
                Forms\Components\TextInput::make('reference_type')
                    ->maxLength(255)
                    ->label('Tipe Referensi'),
                Forms\Components\TextInput::make('reference_id')
                    ->numeric()
                    ->label('ID Referensi'),
                Forms\Components\TextInput::make('quantity_in')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->label('Masuk'),
                Forms\Components\TextInput::make('quantity_out')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->label('Keluar'),
                Forms\Components\TextInput::make('quantity_before')
                    ->required()
                    ->numeric()
                    ->label('Stok Sebelum'),
                Forms\Components\TextInput::make('quantity_after')
                    ->required()
                    ->numeric()
                    ->label('Stok Sesudah'),
                Forms\Components\TextInput::make('unit_cost')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->label('Harga Satuan'),
                Forms\Components\DatePicker::make('transaction_date')
                    ->required()
                    ->label('Tgl Transaksi'),
                Forms\Components\TextInput::make('notes')
                    ->maxLength(255)
                    ->label('Catatan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transaction_date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('productVariant.name')
                    ->label('Varian'),
                Tables\Columns\TextColumn::make('warehouse.name')
                    ->label('Gudang'),
                Tables\Columns\TextColumn::make('reference_type')
                    ->label('Tipe'),
                Tables\Columns\TextColumn::make('quantity_in')
                    ->label('Masuk')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity_out')
                    ->label('Keluar')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity_before')
                    ->label('Sebelum')
                    ->numeric(),
                Tables\Columns\TextColumn::make('quantity_after')
                    ->label('Sesudah')
                    ->numeric(),
                Tables\Columns\TextColumn::make('unit_cost')
                    ->label('Harga')
                    ->numeric(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInventoryMovements::route('/'),
            'create' => Pages\CreateInventoryMovement::route('/create'),
            'edit' => Pages\EditInventoryMovement::route('/{record}/edit'),
        ];
    }
}
