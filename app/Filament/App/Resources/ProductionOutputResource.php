<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\ProductionOutputResource\Pages;
use App\Models\ProductionOutput;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductionOutputResource extends Resource
{
    protected static ?string $model = ProductionOutput::class;

    protected static ?string $navigationGroup = '🏭 Produksi';
    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?int $navigationSort = 154;
    protected static ?string $modelLabel = 'Output Produksi';
    protected static ?string $pluralModelLabel = 'Output Produksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('production_order_id')
                    ->relationship('productionOrder', 'order_no')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Production Order'),
                Forms\Components\Select::make('work_order_id')
                    ->relationship('workOrder', 'work_order_no')
                    ->searchable()
                    ->preload()
                    ->label('Work Order'),
                Forms\Components\DatePicker::make('output_date')
                    ->required()
                    ->default(now())
                    ->label('Tgl Output'),
                Forms\Components\Select::make('output_type')
                    ->required()
                    ->options([
                        'good' => 'Good',
                        'reject' => 'Reject',
                        'rework' => 'Rework',
                    ])
                    ->label('Tipe Output'),
                Forms\Components\Select::make('product_variant_id')
                    ->relationship('productVariant', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Produk'),
                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->label('Qty'),
                Forms\Components\TextInput::make('unit_cost')
                    ->numeric()
                    ->default(0.00)
                    ->prefix('Rp')
                    ->label('Biaya Satuan'),
                Forms\Components\Select::make('warehouse_id')
                    ->relationship('warehouse', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Gudang'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('productionOrder.order_no')
                    ->label('No. PO')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('workOrder.work_order_no')
                    ->label('No. WO')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('output_date')
                    ->label('Tgl Output')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('output_type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'good' => 'success',
                        'reject' => 'danger',
                        'rework' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('productVariant.name')
                    ->label('Produk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Qty')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit_cost')
                    ->label('Biaya Satuan')
                    ->money('IDR')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('warehouse.name')
                    ->label('Gudang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
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
            'index' => Pages\ListProductionOutputs::route('/'),
            'create' => Pages\CreateProductionOutput::route('/create'),
            'edit' => Pages\EditProductionOutput::route('/{record}/edit'),
        ];
    }
}
