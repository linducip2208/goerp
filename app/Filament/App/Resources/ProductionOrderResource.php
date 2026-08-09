<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\ProductionOrderResource\Pages;
use App\Filament\App\Resources\ProductionOrderResource\RelationManagers\WorkOrdersRelationManager;
use App\Filament\App\Resources\ProductionOrderResource\RelationManagers\MaterialRequestsRelationManager;
use App\Filament\App\Resources\ProductionOrderResource\RelationManagers\OutputsRelationManager;
use App\Models\ProductionOrder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductionOrderResource extends Resource
{
    protected static ?string $model = ProductionOrder::class;

    protected static ?string $navigationGroup = '🏭 Manufaktur';
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?int $navigationSort = 71;
    protected static ?string $modelLabel = 'Production Order';
    protected static ?string $pluralModelLabel = 'Production Order';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Hidden::make('company_id'),
                Forms\Components\Select::make('product_variant_id')
                    ->relationship('productVariant', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Produk Jadi'),
                Forms\Components\Select::make('bom_id')
                    ->relationship('bom', 'bom_no')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('BOM'),
                Forms\Components\TextInput::make('order_no')
                    ->required()
                    ->maxLength(255)
                    ->label('No. Order'),
                Forms\Components\TextInput::make('target_qty')
                    ->required()
                    ->numeric()
                    ->label('Target Qty'),
                Forms\Components\DatePicker::make('start_date')
                    ->required()
                    ->label('Tgl Mulai'),
                Forms\Components\DatePicker::make('due_date')
                    ->required()
                    ->label('Tgl Selesai'),
                Forms\Components\Select::make('raw_warehouse_id')
                    ->relationship('rawWarehouse', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Gudang Bahan'),
                Forms\Components\Select::make('finished_warehouse_id')
                    ->relationship('finishedWarehouse', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Gudang Jadi'),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'draft' => 'Draft',
                        'confirmed' => 'Confirmed',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('draft')
                    ->label('Status'),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull()
                    ->label('Catatan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_no')
                    ->label('No. Order')
                    ->searchable(),
                Tables\Columns\TextColumn::make('productVariant.name')
                    ->label('Produk Jadi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('target_qty')
                    ->label('Target Qty')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('actual_output_qty')
                    ->label('Output Aktual')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'confirmed' => 'info',
                        'in_progress' => 'warning',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Tgl Mulai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->label('Tgl Selesai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rawWarehouse.name')
                    ->label('Gudang Bahan')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('finishedWarehouse.name')
                    ->label('Gudang Jadi')
                    ->toggleable(isToggledHiddenByDefault: true),
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
            WorkOrdersRelationManager::class,
            MaterialRequestsRelationManager::class,
            OutputsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductionOrders::route('/'),
            'create' => Pages\CreateProductionOrder::route('/create'),
            'edit' => Pages\EditProductionOrder::route('/{record}/edit'),
        ];
    }
}
