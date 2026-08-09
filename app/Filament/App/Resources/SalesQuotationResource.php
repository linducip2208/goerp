<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\SalesQuotationResource\Pages;
use App\Filament\App\Resources\SalesQuotationResource\RelationManagers\ItemsRelationManager;
use App\Models\SalesQuotation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SalesQuotationResource extends Resource
{
    protected static ?string $model = SalesQuotation::class;

    protected static ?string $navigationGroup = '💰 Penjualan';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 30;
    protected static ?string $modelLabel = 'Penawaran';
    protected static ?string $pluralModelLabel = 'Penawaran';

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
                Forms\Components\TextInput::make('quotation_no')
                    ->required()
                    ->maxLength(255)
                    ->label('No. Penawaran'),
                Forms\Components\DatePicker::make('quotation_date')
                    ->required()
                    ->label('Tgl Penawaran'),
                Forms\Components\DatePicker::make('expiry_date')
                    ->label('Tgl Kadaluarsa'),
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
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'draft' => 'Draft',
                        'sent' => 'Terkirim',
                        'accepted' => 'Diterima',
                        'rejected' => 'Ditolak',
                        'expired' => 'Kadaluarsa',
                        'converted' => 'Dikonversi',
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
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull()
                    ->label('Catatan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('quotation_no')
                    ->label('No. Penawaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quotation_date')
                    ->label('Tgl Penawaran')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expiry_date')
                    ->label('Tgl Kadaluarsa')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sales.name')
                    ->label('Sales'),
                Tables\Columns\TextColumn::make('warehouse.name')
                    ->label('Gudang'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'sent' => 'warning',
                        'accepted' => 'success',
                        'rejected' => 'danger',
                        'expired' => 'danger',
                        'converted' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('grand_total')
                    ->label('Grand Total')
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
                Tables\Actions\Action::make('convert_to_order')
                    ->label('Konversi ke SO')
                    ->icon('heroicon-o-arrow-right-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn (SalesQuotation $record) => static::convertToSalesOrder($record)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function convertToSalesOrder(SalesQuotation $quotation): void
    {
        $order = \App\Models\SalesOrder::create([
            'tenant_id' => $quotation->tenant_id,
            'company_id' => $quotation->company_id,
            'customer_id' => $quotation->customer_id,
            'quotation_id' => $quotation->id,
            'order_no' => 'SO-' . date('Ymd') . '-' . str_pad(\App\Models\SalesOrder::max('id') + 1, 4, '0', STR_PAD_LEFT),
            'order_date' => now()->format('Y-m-d'),
            'warehouse_id' => $quotation->warehouse_id,
            'branch_id' => $quotation->branch_id,
            'status' => 'draft',
            'subtotal' => $quotation->subtotal,
            'discount_total' => $quotation->discount_total,
            'tax_total' => $quotation->tax_total,
            'grand_total' => $quotation->grand_total,
            'notes' => $quotation->notes,
        ]);

        foreach ($quotation->items as $item) {
            $order->items()->create([
                'product_variant_id' => $item->product_variant_id,
                'description' => $item->description,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'discount_percent' => $item->discount_percent,
                'discount_amount' => $item->discount_amount,
                'tax_percent' => $item->tax_percent,
                'tax_amount' => $item->tax_amount,
                'subtotal' => $item->subtotal,
                'total' => $item->total,
            ]);
        }

        $quotation->update(['status' => 'converted']);

        \Filament\Notifications\Notification::make()
            ->title('Penawaran berhasil dikonversi ke Sales Order')
            ->success()
            ->send();
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
            'index' => Pages\ListSalesQuotations::route('/'),
            'create' => Pages\CreateSalesQuotation::route('/create'),
            'edit' => Pages\EditSalesQuotation::route('/{record}/edit'),
        ];
    }
}
