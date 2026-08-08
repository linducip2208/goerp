<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalesDeliveryResource\Pages;
use App\Filament\Resources\SalesDeliveryResource\RelationManagers\ItemsRelationManager;
use App\Models\SalesDelivery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SalesDeliveryResource extends Resource
{
    protected static ?string $model = SalesDelivery::class;

    protected static ?string $navigationGroup = '💰 Penjualan';
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?int $navigationSort = 24;
    protected static ?string $modelLabel = 'Pengiriman';
    protected static ?string $pluralModelLabel = 'Pengiriman';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Hidden::make('company_id'),
                Forms\Components\Select::make('sales_order_id')
                    ->relationship('salesOrder', 'order_no')
                    ->searchable()
                    ->required()
                    ->label('Sales Order'),
                Forms\Components\TextInput::make('delivery_no')
                    ->required()
                    ->maxLength(255)
                    ->label('No. Pengiriman'),
                Forms\Components\DatePicker::make('delivery_date')
                    ->required()
                    ->label('Tgl Pengiriman'),
                Forms\Components\Select::make('warehouse_id')
                    ->relationship('warehouse', 'name')
                    ->label('Gudang'),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'draft' => 'Draft',
                        'delivered' => 'Terkirim',
                        'cancelled' => 'Dibatalkan',
                    ])
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
                Tables\Columns\TextColumn::make('delivery_no')
                    ->label('No. Pengiriman')
                    ->searchable(),
                Tables\Columns\TextColumn::make('salesOrder.order_no')
                    ->label('Sales Order')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('delivery_date')
                    ->label('Tgl Pengiriman')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('warehouse.name')
                    ->label('Gudang'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
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
            ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSalesDeliveries::route('/'),
            'create' => Pages\CreateSalesDelivery::route('/create'),
            'edit' => Pages\EditSalesDelivery::route('/{record}/edit'),
        ];
    }
}
