<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\BankAccountResource\Pages;
use App\Models\BankAccount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BankAccountResource extends Resource
{
    protected static ?string $model = BankAccount::class;

    protected static ?string $navigationGroup = 'Operasional';
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?int $navigationSort = 56;
    protected static ?string $modelLabel = 'Rekening Bank';
    protected static ?string $pluralModelLabel = 'Rekening Bank';

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
                Forms\Components\Select::make('account_id')
                    ->relationship('account', 'name')
                    ->searchable()
                    ->label('Akun COA'),
                Forms\Components\TextInput::make('bank_name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Bank'),
                Forms\Components\TextInput::make('account_no')
                    ->required()
                    ->maxLength(255)
                    ->label('No. Rekening'),
                Forms\Components\TextInput::make('account_name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Pemilik'),
                Forms\Components\TextInput::make('initial_balance')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->label('Saldo Awal'),
                Forms\Components\TextInput::make('current_balance')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->label('Saldo Saat Ini'),
                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->label('Aktif'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('bank_name')
                    ->label('Bank')
                    ->searchable(),
                Tables\Columns\TextColumn::make('account_no')
                    ->label('No. Rekening')
                    ->searchable(),
                Tables\Columns\TextColumn::make('account_name')
                    ->label('Pemilik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Perusahaan'),
                Tables\Columns\TextColumn::make('account.code')
                    ->label('Akun COA'),
                Tables\Columns\TextColumn::make('current_balance')
                    ->label('Saldo')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
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
            'index' => Pages\ListBankAccounts::route('/'),
            'create' => Pages\CreateBankAccount::route('/create'),
            'edit' => Pages\EditBankAccount::route('/{record}/edit'),
        ];
    }
}
