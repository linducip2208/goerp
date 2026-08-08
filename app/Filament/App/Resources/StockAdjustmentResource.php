<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\StockAdjustmentResource\Pages;
use App\Models\StockAdjustment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StockAdjustmentResource extends Resource
{
    protected static ?string $model = StockAdjustment::class;

    protected static ?string $navigationGroup = '📦 Inventory';
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?int $navigationSort = 18;
    protected static ?string $modelLabel = 'Penyesuaian Stok';
    protected static ?string $pluralModelLabel = 'Penyesuaian Stok';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Select::make('warehouse_id')
                    ->relationship('warehouse', 'name')
                    ->required()
                    ->label('Gudang'),
                Forms\Components\Select::make('product_variant_id')
                    ->relationship('productVariant', 'name')
                    ->searchable()
                    ->required()
                    ->label('Produk'),
                Forms\Components\Select::make('adjustment_type')
                    ->required()
                    ->options([
                        'in' => 'Masuk',
                        'out' => 'Keluar',
                        'lost' => 'Hilang',
                        'damage' => 'Rusak',
                        'reject' => 'Reject',
                        'correction' => 'Koreksi',
                        'return' => 'Retur',
                    ])
                    ->label('Tipe Penyesuaian'),
                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->label('Qty'),
                Forms\Components\TextInput::make('unit_cost')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->label('Harga Satuan'),
                Forms\Components\Textarea::make('reason')
                    ->label('Alasan'),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('User'),
                Forms\Components\Select::make('approved_by')
                    ->relationship('approvedBy', 'name')
                    ->searchable()
                    ->label('Disetujui Oleh'),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'draft' => 'Draft',
                        'approved' => 'Disetujui',
                        'cancelled' => 'Dibatalkan',
                    ])
                    ->label('Status'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('warehouse.name')
                    ->label('Gudang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('productVariant.name')
                    ->label('Produk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('adjustment_type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'in' => 'success',
                        'out' => 'danger',
                        'lost' => 'danger',
                        'damage' => 'warning',
                        'reject' => 'warning',
                        'correction' => 'info',
                        'return' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Qty')
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit_cost')
                    ->label('Harga Satuan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'approved' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
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
            'index' => Pages\ListStockAdjustments::route('/'),
            'create' => Pages\CreateStockAdjustment::route('/create'),
            'edit' => Pages\EditStockAdjustment::route('/{record}/edit'),
        ];
    }
}
