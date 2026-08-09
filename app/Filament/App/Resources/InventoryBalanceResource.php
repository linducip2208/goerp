<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\InventoryBalanceResource\Pages;
use App\Models\InventoryBalance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InventoryBalanceResource extends Resource
{
    protected static ?string $model = InventoryBalance::class;

    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationIcon = 'heroicon-o-scale';
    protected static ?int $navigationSort = 108;
    protected static ?string $modelLabel = 'Stok';
    protected static ?string $pluralModelLabel = 'Stok';

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
                Forms\Components\TextInput::make('on_hand')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->label('Stok Tersedia'),
                Forms\Components\TextInput::make('reserved')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->label('Dipesan'),
                Forms\Components\TextInput::make('available')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->label('Tersedia'),
                Forms\Components\TextInput::make('average_cost')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->label('Harga Rata-Rata'),
                Forms\Components\TextInput::make('last_purchase_cost')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->label('Harga Beli Terakhir'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('productVariant.name')
                    ->label('Varian')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('warehouse.name')
                    ->label('Gudang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('on_hand')
                    ->label('Tersedia')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reserved')
                    ->label('Dipesan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('available')
                    ->label('Tersedia (Net)')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('average_cost')
                    ->label('Harga Rata')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_purchase_cost')
                    ->label('Harga Beli Terakhir')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListInventoryBalances::route('/'),
            'create' => Pages\CreateInventoryBalance::route('/create'),
            'edit' => Pages\EditInventoryBalance::route('/{record}/edit'),
        ];
    }
}
