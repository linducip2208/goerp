<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FiscalPeriodResource\Pages;
use App\Models\FiscalPeriod;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FiscalPeriodResource extends Resource
{
    protected static ?string $model = FiscalPeriod::class;

    protected static ?string $navigationGroup = '📊 Accounting';
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?int $navigationSort = 58;
    protected static ?string $modelLabel = 'Periode Fiskal';
    protected static ?string $pluralModelLabel = 'Periode Fiskal';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Hidden::make('company_id'),
                Forms\Components\TextInput::make('period')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('YYYY-MM')
                    ->label('Periode'),
                Forms\Components\DatePicker::make('start_date')
                    ->required()
                    ->label('Tgl Mulai'),
                Forms\Components\DatePicker::make('end_date')
                    ->required()
                    ->label('Tgl Selesai'),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'open' => 'Buka',
                        'closed' => 'Tutup',
                    ])
                    ->default('open')
                    ->label('Status'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('period')
                    ->label('Periode')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Tgl Mulai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Tgl Selesai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'open' => 'success',
                        'closed' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status'),
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
            'index' => Pages\ListFiscalPeriods::route('/'),
            'create' => Pages\CreateFiscalPeriod::route('/create'),
            'edit' => Pages\EditFiscalPeriod::route('/{record}/edit'),
        ];
    }
}
