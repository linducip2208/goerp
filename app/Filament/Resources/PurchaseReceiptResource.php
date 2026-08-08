<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseReceiptResource\Pages;
use App\Filament\Resources\PurchaseReceiptResource\RelationManagers\ItemsRelationManager;
use App\Models\PurchaseReceipt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PurchaseReceiptResource extends Resource
{
    protected static ?string $model = PurchaseReceipt::class;

    protected static ?string $navigationGroup = '🏭 Warehouse';
    protected static ?string $navigationIcon = 'heroicon-o-archive-box-arrow-down';
    protected static ?int $navigationSort = 34;
    protected static ?string $modelLabel = 'Penerimaan Barang';
    protected static ?string $pluralModelLabel = 'Penerimaan Barang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Hidden::make('company_id'),
                Forms\Components\Select::make('purchase_order_id')
                    ->relationship('purchaseOrder', 'order_no')
                    ->searchable()
                    ->required()
                    ->label('Purchase Order'),
                Forms\Components\TextInput::make('receipt_no')
                    ->required()
                    ->maxLength(255)
                    ->label('No. Penerimaan'),
                Forms\Components\DatePicker::make('receipt_date')
                    ->required()
                    ->label('Tgl Penerimaan'),
                Forms\Components\Select::make('warehouse_id')
                    ->relationship('warehouse', 'name')
                    ->label('Gudang'),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'draft' => 'Draft',
                        'received' => 'Diterima',
                        'cancelled' => 'Dibatalkan',
                    ])
                    ->label('Status'),
                Forms\Components\DateTimePicker::make('posted_at')
                    ->label('Tgl Posting'),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull()
                    ->label('Catatan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('receipt_no')
                    ->label('No. Penerimaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('purchaseOrder.order_no')
                    ->label('Purchase Order')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('receipt_date')
                    ->label('Tgl Penerimaan')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('warehouse.name')
                    ->label('Gudang'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'received' => 'success',
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
            'index' => Pages\ListPurchaseReceipts::route('/'),
            'create' => Pages\CreatePurchaseReceipt::route('/create'),
            'edit' => Pages\EditPurchaseReceipt::route('/{record}/edit'),
        ];
    }
}
