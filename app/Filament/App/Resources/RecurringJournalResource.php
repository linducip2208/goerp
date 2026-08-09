<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\RecurringJournalResource\Pages;
use App\Models\RecurringJournal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RecurringJournalResource extends Resource
{
    protected static ?string $model = RecurringJournal::class;

    protected static ?string $navigationGroup = null;
    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?int $navigationSort = 999;
    protected static ?string $modelLabel = 'Jurnal Berulang';
    protected static ?string $pluralModelLabel = 'Jurnal Berulang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Hidden::make('company_id'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama'),
                Forms\Components\Select::make('frequency')
                    ->required()
                    ->options([
                        'daily' => 'Harian',
                        'weekly' => 'Mingguan',
                        'monthly' => 'Bulanan',
                        'quarterly' => 'Triwulan',
                        'yearly' => 'Tahunan',
                    ])
                    ->default('monthly')
                    ->label('Frekuensi'),
                Forms\Components\DatePicker::make('next_date')
                    ->label('Tgl Berikutnya'),
                Forms\Components\Select::make('account_debit_id')
                    ->relationship('accountDebit', 'name')
                    ->searchable()
                    ->required()
                    ->label('Akun Debit'),
                Forms\Components\Select::make('account_credit_id')
                    ->relationship('accountCredit', 'name')
                    ->searchable()
                    ->required()
                    ->label('Akun Kredit'),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->label('Jumlah'),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull()
                    ->label('Deskripsi'),
                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->default(true)
                    ->label('Aktif'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('frequency')
                    ->label('Frekuensi')
                    ->badge(),
                Tables\Columns\TextColumn::make('next_date')
                    ->label('Tgl Berikutnya')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('accountDebit.name')
                    ->label('Akun Debit'),
                Tables\Columns\TextColumn::make('accountCredit.name')
                    ->label('Akun Kredit'),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('IDR')
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
            'index' => Pages\ListRecurringJournals::route('/'),
            'create' => Pages\CreateRecurringJournal::route('/create'),
            'edit' => Pages\EditRecurringJournal::route('/{record}/edit'),
        ];
    }
}
