<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Models\Expense;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationGroup = '💵 Finance';
    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';
    protected static ?int $navigationSort = 43;
    protected static ?string $modelLabel = 'Biaya';
    protected static ?string $pluralModelLabel = 'Biaya';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Hidden::make('company_id'),
                Forms\Components\TextInput::make('expense_no')
                    ->required()
                    ->maxLength(255)
                    ->label('No. Biaya'),
                Forms\Components\DatePicker::make('expense_date')
                    ->required()
                    ->label('Tgl Biaya'),
                Forms\Components\TextInput::make('payee')
                    ->required()
                    ->maxLength(255)
                    ->label('Penerima'),
                Forms\Components\Select::make('account_id')
                    ->relationship('account', 'name')
                    ->searchable()
                    ->required()
                    ->label('Akun'),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->label('Jumlah'),
                Forms\Components\TextInput::make('tax_amount')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->label('Pajak'),
                Forms\Components\Select::make('bank_account_id')
                    ->relationship('bankAccount', 'account_name')
                    ->searchable()
                    ->label('Rekening Bank'),
                Forms\Components\Select::make('branch_id')
                    ->relationship('branch', 'name')
                    ->label('Cabang'),
                Forms\Components\TextInput::make('department')
                    ->maxLength(255)
                    ->label('Departemen'),
                Forms\Components\TextInput::make('memo')
                    ->maxLength(255)
                    ->label('Memo'),
                Forms\Components\TextInput::make('attachment')
                    ->maxLength(255)
                    ->label('Lampiran'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('expense_no')
                    ->label('No. Biaya')
                    ->searchable(),
                Tables\Columns\TextColumn::make('expense_date')
                    ->label('Tgl')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payee')
                    ->label('Penerima')
                    ->searchable(),
                Tables\Columns\TextColumn::make('account.name')
                    ->label('Akun')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Jumlah')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bankAccount.account_name')
                    ->label('Rekening Bank'),
                Tables\Columns\TextColumn::make('branch.name')
                    ->label('Cabang'),
                Tables\Columns\TextColumn::make('department')
                    ->label('Dept')
                    ->searchable(),
                Tables\Columns\TextColumn::make('memo')
                    ->label('Memo')
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
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
