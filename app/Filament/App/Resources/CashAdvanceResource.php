<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\CashAdvanceResource\Pages;
use App\Models\CashAdvance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CashAdvanceResource extends Resource
{
    protected static ?string $model = CashAdvance::class;

    protected static ?string $navigationGroup = '💵 Finance';
    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-circle';
    protected static ?int $navigationSort = 45;
    protected static ?string $modelLabel = 'Uang Muka';
    protected static ?string $pluralModelLabel = 'Uang Muka';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Hidden::make('company_id'),
                Forms\Components\TextInput::make('advance_no')
                    ->required()
                    ->maxLength(255)
                    ->label('No. Uang Muka'),
                Forms\Components\DatePicker::make('advance_date')
                    ->required()
                    ->label('Tgl Uang Muka'),
                Forms\Components\Select::make('employee_id')
                    ->relationship('employee', 'name')
                    ->searchable()
                    ->required()
                    ->label('Karyawan'),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->label('Jumlah'),
                Forms\Components\TextInput::make('purpose')
                    ->maxLength(255)
                    ->label('Tujuan'),
                Forms\Components\DatePicker::make('settlement_date')
                    ->label('Tgl Pelunasan'),
                Forms\Components\TextInput::make('settled_amount')
                    ->numeric()
                    ->default(0)
                    ->label('Jumlah Pelunasan'),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'requested' => 'Diminta',
                        'approved' => 'Disetujui',
                        'paid' => 'Dibayar',
                        'settled' => 'Dilunasi',
                    ])
                    ->default('requested')
                    ->label('Status'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('advance_no')
                    ->label('No. Uang Muka')
                    ->searchable(),
                Tables\Columns\TextColumn::make('advance_date')
                    ->label('Tgl')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee.name')
                    ->label('Karyawan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('purpose')
                    ->label('Tujuan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('settlement_date')
                    ->label('Tgl Pelunasan')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('settled_amount')
                    ->label('Dilunasi')
                    ->money('IDR'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'requested' => 'warning',
                        'approved' => 'info',
                        'paid' => 'primary',
                        'settled' => 'success',
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
            'index' => Pages\ListCashAdvances::route('/'),
            'create' => Pages\CreateCashAdvance::route('/create'),
            'edit' => Pages\EditCashAdvance::route('/{record}/edit'),
        ];
    }
}
