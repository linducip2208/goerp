<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\SalesInvoiceResource\Pages;
use App\Filament\App\Resources\SalesInvoiceResource\RelationManagers\ItemsRelationManager;
use App\Filament\App\Resources\SalesInvoiceResource\RelationManagers\PaymentsRelationManager;
use App\Models\SalesInvoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class SalesInvoiceResource extends Resource
{
    protected static ?string $model = SalesInvoice::class;

    protected static ?string $navigationGroup = '💰 Penjualan';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 32;
    protected static ?string $modelLabel = 'Faktur Penjualan';
    protected static ?string $pluralModelLabel = 'Faktur Penjualan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Hidden::make('company_id'),
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->required()
                    ->label('Customer'),
                Forms\Components\TextInput::make('invoice_no')
                    ->required()
                    ->maxLength(255)
                    ->label('No. Faktur'),
                Forms\Components\DatePicker::make('invoice_date')
                    ->required()
                    ->label('Tgl Faktur'),
                Forms\Components\DatePicker::make('due_date')
                    ->required()
                    ->label('Jatuh Tempo'),
                Forms\Components\Select::make('sales_id')
                    ->relationship('sales', 'name')
                    ->searchable()
                    ->label('Sales'),
                Forms\Components\Select::make('branch_id')
                    ->relationship('branch', 'name')
                    ->label('Cabang'),
                Forms\Components\Select::make('warehouse_id')
                    ->relationship('warehouse', 'name')
                    ->label('Gudang'),
                Forms\Components\TextInput::make('channel')
                    ->maxLength(255)
                    ->label('Channel'),
                Forms\Components\Select::make('currency_id')
                    ->relationship('currency', 'code')
                    ->searchable()
                    ->label('Mata Uang'),
                Forms\Components\TextInput::make('reference')
                    ->maxLength(255)
                    ->label('Referensi'),
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
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull()
                    ->label('Catatan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_no')
                    ->label('No. Faktur')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('invoice_date')
                    ->label('Tgl Faktur')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->label('Jatuh Tempo')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('branch.name')
                    ->label('Cabang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('warehouse.name')
                    ->label('Gudang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sales.name')
                    ->label('Sales'),
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
                Tables\Columns\TextColumn::make('currency.code')
                    ->label('Mata Uang')
                    ->default('IDR'),
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
                Action::make('pdf')
                    ->icon('heroicon-o-document-arrow-down')
                    ->label('PDF')
                    ->url(fn($record) => route('invoice.pdf', $record))
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListSalesInvoices::route('/'),
            'create' => Pages\CreateSalesInvoice::route('/create'),
            'edit' => Pages\EditSalesInvoice::route('/{record}/edit'),
        ];
    }
}
