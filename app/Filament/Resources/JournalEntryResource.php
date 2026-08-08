<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JournalEntryResource\Pages;
use App\Filament\Resources\JournalEntryResource\RelationManagers\LinesRelationManager;
use App\Models\JournalEntry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JournalEntryResource extends Resource
{
    protected static ?string $model = JournalEntry::class;

    protected static ?string $navigationGroup = '📊 Accounting';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?int $navigationSort = 52;
    protected static ?string $modelLabel = 'Jurnal';
    protected static ?string $pluralModelLabel = 'Jurnal';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Hidden::make('company_id'),
                Forms\Components\Hidden::make('created_by'),
                Forms\Components\TextInput::make('journal_no')
                    ->required()
                    ->maxLength(255)
                    ->label('No. Jurnal'),
                Forms\Components\DatePicker::make('journal_date')
                    ->required()
                    ->label('Tgl Jurnal'),
                Forms\Components\TextInput::make('source_type')
                    ->maxLength(255)
                    ->label('Sumber'),
                Forms\Components\TextInput::make('source_id')
                    ->numeric()
                    ->label('ID Sumber'),
                Forms\Components\TextInput::make('reference')
                    ->maxLength(255)
                    ->label('Referensi'),
                Forms\Components\Textarea::make('description')
                    ->maxLength(255)
                    ->label('Deskripsi'),
                Forms\Components\TextInput::make('total_debit')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->label('Total Debit'),
                Forms\Components\TextInput::make('total_credit')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->label('Total Kredit'),
                Forms\Components\Toggle::make('is_posted')
                    ->required()
                    ->label('Diposting'),
                Forms\Components\Hidden::make('posted_by'),
                Forms\Components\Hidden::make('posted_at'),
                Forms\Components\TextInput::make('period')
                    ->maxLength(255)
                    ->label('Periode'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('journal_no')
                    ->label('No. Jurnal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('journal_date')
                    ->label('Tgl Jurnal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('source_type')
                    ->label('Sumber'),
                Tables\Columns\TextColumn::make('reference')
                    ->label('Referensi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_debit')
                    ->label('Total Debit')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_credit')
                    ->label('Total Kredit')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_posted')
                    ->label('Diposting')
                    ->boolean(),
                Tables\Columns\TextColumn::make('period')
                    ->label('Periode'),
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
            LinesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJournalEntries::route('/'),
            'create' => Pages\CreateJournalEntry::route('/create'),
            'edit' => Pages\EditJournalEntry::route('/{record}/edit'),
        ];
    }
}
