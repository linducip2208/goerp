<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\PurchaseOrderResource\Pages;
use App\Filament\App\Resources\PurchaseOrderResource\RelationManagers\ItemsRelationManager;
use App\Models\PurchaseOrder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PurchaseOrderResource extends Resource
{
    protected static ?string $model = PurchaseOrder::class;

    protected static ?string $navigationGroup = '🛒 Pembelian';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?int $navigationSort = 51;
    protected static ?string $modelLabel = 'Purchase Order';
    protected static ?string $pluralModelLabel = 'Purchase Order';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Hidden::make('company_id'),
                Forms\Components\Select::make('supplier_id')
                    ->relationship('supplier', 'name')
                    ->searchable()
                    ->required()
                    ->label('Supplier'),
                Forms\Components\TextInput::make('order_no')
                    ->required()
                    ->maxLength(255)
                    ->label('No. Order'),
                Forms\Components\DatePicker::make('order_date')
                    ->required()
                    ->label('Tgl Order'),
                Forms\Components\DatePicker::make('expected_delivery')
                    ->label('Estimasi Kirim'),
                Forms\Components\Select::make('warehouse_id')
                    ->relationship('warehouse', 'name')
                    ->label('Gudang'),
                Forms\Components\Select::make('branch_id')
                    ->relationship('branch', 'name')
                    ->label('Cabang'),
                Forms\Components\TextInput::make('currency')
                    ->required()
                    ->maxLength(255)
                    ->default('IDR')
                    ->label('Mata Uang'),
                Forms\Components\TextInput::make('payment_term')
                    ->maxLength(255)
                    ->label('Term Pembayaran'),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'draft' => 'Draft',
                        'sent' => 'Sent',
                        'partial' => 'Partial',
                        'received' => 'Received',
                        'cancelled' => 'Cancelled',
                    ])
                    ->label('Status'),
                Forms\Components\TextInput::make('subtotal')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->label('Subtotal'),
                Forms\Components\TextInput::make('discount_total')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->label('Diskon'),
                Forms\Components\TextInput::make('tax_total')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->label('Pajak'),
                Forms\Components\TextInput::make('grand_total')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->label('Grand Total'),
                Forms\Components\Select::make('approved_by')
                    ->relationship('approvedBy', 'name')
                    ->searchable()
                    ->label('Disetujui Oleh'),
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
                Tables\Columns\TextColumn::make('supplier.name')
                    ->label('Supplier')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order_date')
                    ->label('Tgl Order')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expected_delivery')
                    ->label('Estimasi Kirim')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('warehouse.name')
                    ->label('Gudang'),
                Tables\Columns\TextColumn::make('branch.name')
                    ->label('Cabang'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'sent' => 'warning',
                        'partial' => 'info',
                        'received' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('grand_total')
                    ->label('Grand Total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('approvedBy.name')
                    ->label('Disetujui Oleh'),
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
            'index' => Pages\ListPurchaseOrders::route('/'),
            'create' => Pages\CreatePurchaseOrder::route('/create'),
            'edit' => Pages\EditPurchaseOrder::route('/{record}/edit'),
        ];
    }
}
