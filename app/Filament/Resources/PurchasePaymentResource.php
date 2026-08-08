<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchasePaymentResource\Pages;
use App\Models\PurchasePayment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PurchasePaymentResource extends Resource
{
    protected static ?string $model = PurchasePayment::class;

    protected static ?string $navigationGroup = '🛒 Pembelian';
    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-on-square';
    protected static ?int $navigationSort = 33;
    protected static ?string $modelLabel = 'Pembayaran Keluar';
    protected static ?string $pluralModelLabel = 'Pembayaran Keluar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Hidden::make('company_id'),
                Forms\Components\Select::make('invoice_id')
                    ->relationship('invoice', 'invoice_supplier_no')
                    ->searchable()
                    ->required()
                    ->label('Faktur'),
                Forms\Components\Select::make('bank_account_id')
                    ->relationship('bankAccount', 'account_name')
                    ->searchable()
                    ->label('Rekening Bank'),
                Forms\Components\TextInput::make('payment_no')
                    ->required()
                    ->maxLength(255)
                    ->label('No. Pembayaran'),
                Forms\Components\DatePicker::make('payment_date')
                    ->required()
                    ->label('Tgl Pembayaran'),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->label('Jumlah'),
                Forms\Components\Select::make('method')
                    ->required()
                    ->options([
                        'cash' => 'Cash',
                        'transfer' => 'Transfer',
                        'giro' => 'Giro',
                        'other' => 'Lainnya',
                    ])
                    ->label('Metode'),
                Forms\Components\TextInput::make('reference')
                    ->maxLength(255)
                    ->label('Referensi'),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull()
                    ->label('Catatan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('payment_no')
                    ->label('No. Pembayaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('invoice.invoice_supplier_no')
                    ->label('Faktur')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_date')
                    ->label('Tgl')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Jumlah')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('method')
                    ->label('Metode')
                    ->badge(),
                Tables\Columns\TextColumn::make('bankAccount.account_name')
                    ->label('Rekening'),
                Tables\Columns\TextColumn::make('reference')
                    ->label('Referensi')
                    ->searchable(),
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
            'index' => Pages\ListPurchasePayments::route('/'),
            'create' => Pages\CreatePurchasePayment::route('/create'),
            'edit' => Pages\EditPurchasePayment::route('/{record}/edit'),
        ];
    }
}
