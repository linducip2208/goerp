<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PieceRateResource\Pages;
use App\Models\PieceRate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PieceRateResource extends Resource
{
    protected static ?string $model = PieceRate::class;

    protected static ?string $navigationGroup = '🏭 Manufacturing';
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?int $navigationSort = 66;
    protected static ?string $modelLabel = 'Borongan';
    protected static ?string $pluralModelLabel = 'Borongan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Hidden::make('company_id'),
                Forms\Components\Select::make('work_order_id')
                    ->relationship('workOrder', 'work_order_no')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Work Order'),
                Forms\Components\TextInput::make('operator_name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Operator'),
                Forms\Components\TextInput::make('operation')
                    ->required()
                    ->maxLength(255)
                    ->label('Operasi'),
                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->label('Qty')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Forms\Set $set, Forms\Get $get) => self::calculateTotal($set, $get)),
                Forms\Components\TextInput::make('rate_per_unit')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Tarif Per Unit')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Forms\Set $set, Forms\Get $get) => self::calculateTotal($set, $get)),
                Forms\Components\TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->disabled()
                    ->dehydrated(true)
                    ->label('Total'),
                Forms\Components\DatePicker::make('payment_date')
                    ->label('Tgl Bayar'),
            ]);
    }

    public static function calculateTotal(Forms\Set $set, Forms\Get $get): void
    {
        $qty = (float) ($get('quantity') ?? 0);
        $rate = (float) ($get('rate_per_unit') ?? 0);

        $set('total_amount', round($qty * $rate, 2));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('workOrder.work_order_no')
                    ->label('No. WO')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('operator_name')
                    ->label('Operator')
                    ->searchable(),
                Tables\Columns\TextColumn::make('operation')
                    ->label('Operasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Qty')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rate_per_unit')
                    ->label('Tarif/Unit')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_date')
                    ->label('Tgl Bayar')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
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
            'index' => Pages\ListPieceRates::route('/'),
            'create' => Pages\CreatePieceRate::route('/create'),
            'edit' => Pages\EditPieceRate::route('/{record}/edit'),
        ];
    }
}
