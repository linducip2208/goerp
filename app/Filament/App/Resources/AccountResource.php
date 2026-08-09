<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\AccountResource\Pages;
use App\Models\Account;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class AccountResource extends Resource
{
    protected static ?string $model = Account::class;

    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?int $navigationSort = 113;
    protected static ?string $modelLabel = 'Chart of Accounts';
    protected static ?string $pluralModelLabel = 'Chart of Accounts';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Hidden::make('company_id'),
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255)
                    ->label('Kode Akun'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Akun'),
                Forms\Components\Select::make('category')
                    ->required()
                    ->options([
                        'asset' => 'Asset',
                        'liability' => 'Liability',
                        'equity' => 'Equity',
                        'revenue' => 'Revenue',
                        'cogs' => 'COGS',
                        'expense' => 'Expense',
                        'other_income' => 'Other Income',
                        'other_expense' => 'Other Expense',
                    ])
                    ->label('Kategori'),
                Forms\Components\Select::make('parent_id')
                    ->relationship('parent', 'name')
                    ->searchable()
                    ->label('Induk Akun'),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull()
                    ->label('Deskripsi'),
                Forms\Components\TextInput::make('currency')
                    ->maxLength(255)
                    ->label('Mata Uang'),
                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->label('Aktif'),
                Forms\Components\TextInput::make('opening_balance')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->label('Saldo Awal'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('hierarchy')
                    ->label('Kode & Nama Akun')
                    ->formatStateUsing(function ($state, $record) {
                        $indent = $record->parent_id ? str_repeat('&#x2014; ', substr_count($record->code, '-')) : '';
                        return '<span class="text-gray-900 font-mono text-xs">' . $record->code . '</span> ' . $indent . '<span class="text-gray-700">' . $record->name . '</span>';
                    })
                    ->html()
                    ->searchable(query: function ($query, $search) {
                        return $query->where(function ($q) use ($search) {
                            $q->where('code', 'like', "%{$search}%")
                              ->orWhere('name', 'like', "%{$search}%");
                        });
                    }),
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'asset' => 'success',
                        'liability' => 'warning',
                        'equity' => 'info',
                        'revenue' => 'primary',
                        'cogs' => 'danger',
                        'expense' => 'gray',
                        'other_income' => 'primary',
                        'other_expense' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('opening_balance')
                    ->label('Saldo Awal')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format((float) $state, 0, ',', '.'))
                    ->sortable()
                    ->alignEnd(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('code')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'asset' => 'Asset',
                        'liability' => 'Liability',
                        'equity' => 'Equity',
                        'revenue' => 'Revenue',
                        'cogs' => 'COGS',
                        'expense' => 'Expense',
                        'other_income' => 'Other Income',
                        'other_expense' => 'Other Expense',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Aktif'),
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
            'index' => Pages\ListAccounts::route('/'),
            'create' => Pages\CreateAccount::route('/create'),
            'edit' => Pages\EditAccount::route('/{record}/edit'),
        ];
    }
}
