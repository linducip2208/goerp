<?php

namespace App\Filament\Resources\ProductionOrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class OutputsRelationManager extends RelationManager
{
    protected static string $relationship = 'outputs';

    protected static ?string $title = 'Output Produksi';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('output_date')
            ->columns([
                Tables\Columns\TextColumn::make('workOrder.work_order_no')
                    ->label('No. WO')
                    ->searchable(),
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
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),
                Tables\Columns\TextColumn::make('warehouse.name')
                    ->label('Gudang'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Output'),
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
