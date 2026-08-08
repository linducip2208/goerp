<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BankTransactionResource\Pages;
use App\Models\BankTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BankTransactionResource extends Resource
{
    protected static ?string $model = BankTransaction::class;

    protected static ?string $navigationGroup = '💵 Finance';
    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';
    protected static ?int $navigationSort = 42;
    protected static ?string $modelLabel = 'Transaksi Bank';
    protected static ?string $pluralModelLabel = 'Transaksi Bank';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Select::make('company_id')
                    ->relationship('company', 'name')
                    ->searchable()
                    ->required()
                    ->label('Perusahaan'),
                Forms\Components\Select::make('bank_account_id')
                    ->relationship('bankAccount', 'account_name')
                    ->searchable()
                    ->required()
                    ->label('Rekening Bank'),
                Forms\Components\Select::make('transaction_type')
                    ->required()
                    ->options([
                        'credit' => 'Kredit (Masuk)',
                        'debit' => 'Debit (Keluar)',
                    ])
                    ->label('Tipe Transaksi'),
                Forms\Components\DatePicker::make('transaction_date')
                    ->required()
                    ->label('Tgl Transaksi'),
                Forms\Components\Select::make('contact_id')
                    ->relationship('contact', 'name')
                    ->searchable()
                    ->label('Kontak'),
                Forms\Components\Select::make('account_id')
                    ->relationship('account', 'name')
                    ->searchable()
                    ->label('Akun'),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->label('Jumlah'),
                Forms\Components\TextInput::make('memo')
                    ->maxLength(255)
                    ->label('Memo'),
                Forms\Components\TextInput::make('reference')
                    ->maxLength(255)
                    ->label('Referensi'),
                Forms\Components\Toggle::make('reconciled')
                    ->required()
                    ->label('Direkonsiliasi'),
                Forms\Components\DateTimePicker::make('reconciled_at')
                    ->label('Tgl Rekonsiliasi'),
                Forms\Components\TextInput::make('attachment')
                    ->maxLength(255)
                    ->label('Lampiran'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('bankAccount.account_name')
                    ->label('Rekening')
                    ->searchable(),
                Tables\Columns\TextColumn::make('transaction_type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'credit' => 'success',
                        'debit' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('transaction_date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('contact.name')
                    ->label('Kontak'),
                Tables\Columns\TextColumn::make('account.code')
                    ->label('Akun'),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Jumlah')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('memo')
                    ->label('Memo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('reference')
                    ->label('Referensi')
                    ->searchable(),
                Tables\Columns\IconColumn::make('reconciled')
                    ->label('Rekonsiliasi')
                    ->boolean(),
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
            'index' => Pages\ListBankTransactions::route('/'),
            'create' => Pages\CreateBankTransaction::route('/create'),
            'edit' => Pages\EditBankTransaction::route('/{record}/edit'),
        ];
    }
}
