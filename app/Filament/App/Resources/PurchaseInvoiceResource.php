<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\PurchaseInvoiceResource\Pages;
use App\Filament\App\Resources\PurchaseInvoiceResource\RelationManagers\ItemsRelationManager;
use App\Filament\App\Resources\PurchaseInvoiceResource\RelationManagers\PaymentsRelationManager;
use App\Models\PurchaseInvoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PurchaseInvoiceResource extends Resource
{
    protected static ?string $model = PurchaseInvoice::class;

    protected static ?string $navigationGroup = '🛒 Pembelian';
    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-down';
    protected static ?int $navigationSort = 52;
    protected static ?string $modelLabel = 'Faktur Pembelian';
    protected static ?string $pluralModelLabel = 'Faktur Pembelian';

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
                Forms\Components\Select::make('purchase_order_id')
                    ->relationship('purchaseOrder', 'order_no')
                    ->searchable()
                    ->label('Purchase Order'),
                Forms\Components\TextInput::make('invoice_supplier_no')
                    ->required()
                    ->maxLength(255)
                    ->label('No. Faktur Supplier'),
                Forms\Components\DatePicker::make('invoice_date')
                    ->required()
                    ->label('Tgl Faktur'),
                Forms\Components\DatePicker::make('due_date')
                    ->required()
                    ->label('Jatuh Tempo'),
                Forms\Components\Select::make('warehouse_id')
                    ->relationship('warehouse', 'name')
                    ->label('Gudang'),
                Forms\Components\Select::make('branch_id')
                    ->relationship('branch', 'name')
                    ->label('Cabang'),
                Forms\Components\Select::make('currency_id')
                    ->relationship('currency', 'code')
                    ->searchable()
                    ->label('Mata Uang'),
                Forms\Components\TextInput::make('reference_no')
                    ->maxLength(255)
                    ->label('No. Referensi'),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'draft' => 'Draft',
                        'open' => 'Open',
                        'partial' => 'Partial',
                        'paid' => 'Paid',
                        'overdue' => 'Overdue',
                        'void' => 'Void',
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
                Forms\Components\TextInput::make('paid_amount')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->label('Terbayar'),
                Forms\Components\TextInput::make('outstanding')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->label('Sisa'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_supplier_no')
                    ->label('No. Faktur Supplier')
                    ->searchable(),
                Tables\Columns\TextColumn::make('supplier.name')
                    ->label('Supplier')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('purchaseOrder.order_no')
                    ->label('PO')
                    ->searchable(),
                Tables\Columns\TextColumn::make('invoice_date')
                    ->label('Tgl Faktur')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->label('Jatuh Tempo')
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
                        'open' => 'warning',
                        'partial' => 'info',
                        'paid' => 'success',
                        'overdue' => 'danger',
                        'void' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('grand_total')
                    ->label('Grand Total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('paid_amount')
                    ->label('Terbayar')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('outstanding')
                    ->label('Sisa')
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
            ItemsRelationManager::class,
            PaymentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchaseInvoices::route('/'),
            'create' => Pages\CreatePurchaseInvoice::route('/create'),
            'edit' => Pages\EditPurchaseInvoice::route('/{record}/edit'),
        ];
    }
}
