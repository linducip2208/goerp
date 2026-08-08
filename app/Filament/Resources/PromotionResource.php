<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromotionResource\Pages;
use App\Models\Promotion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PromotionResource extends Resource
{
    protected static ?string $model = Promotion::class;

    protected static ?string $navigationGroup = '🛍️ Marketplace';
    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?int $navigationSort = 152;
    protected static ?string $modelLabel = 'Promosi';
    protected static ?string $pluralModelLabel = 'Promosi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama'),
                Forms\Components\Select::make('type')
                    ->required()
                    ->options([
                        'percentage' => 'Persentase',
                        'fixed' => 'Nominal',
                        'buy_x_get_y' => 'Beli X Gratis Y',
                    ])
                    ->label('Tipe'),
                Forms\Components\TextInput::make('value')
                    ->required()
                    ->numeric()
                    ->label('Nilai'),
                Forms\Components\DatePicker::make('start_date')
                    ->label('Tgl Mulai'),
                Forms\Components\DatePicker::make('end_date')
                    ->label('Tgl Selesai'),
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
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'percentage' => 'info',
                        'fixed' => 'success',
                        'buy_x_get_y' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('value')
                    ->label('Nilai')
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Tgl Mulai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Tgl Selesai')
                    ->date()
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
            'index' => Pages\ListPromotions::route('/'),
            'create' => Pages\CreatePromotion::route('/create'),
            'edit' => Pages\EditPromotion::route('/{record}/edit'),
        ];
    }
}
