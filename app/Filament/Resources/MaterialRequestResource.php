<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaterialRequestResource\Pages;

use App\Models\MaterialRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MaterialRequestResource extends Resource
{
    protected static ?string $model = MaterialRequest::class;

    protected static ?string $navigationGroup = '🏭 Manufacturing';
    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';
    protected static ?int $navigationSort = 64;
    protected static ?string $modelLabel = 'Permintaan Material';
    protected static ?string $pluralModelLabel = 'Permintaan Material';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('production_order_id')
                    ->relationship('productionOrder', 'order_no')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Production Order'),
                Forms\Components\TextInput::make('request_no')
                    ->required()
                    ->maxLength(255)
                    ->label('No. Permintaan'),
                Forms\Components\DatePicker::make('request_date')
                    ->required()
                    ->default(now())
                    ->label('Tgl Permintaan'),
                Forms\Components\Select::make('warehouse_id')
                    ->relationship('warehouse', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Gudang'),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'draft' => 'Draft',
                        'requested' => 'Diminta',
                        'issued' => 'Dikeluarkan',
                    ])
                    ->default('draft')
                    ->label('Status'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('request_no')
                    ->label('No. Permintaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('productionOrder.order_no')
                    ->label('No. PO')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('request_date')
                    ->label('Tgl Permintaan')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('warehouse.name')
                    ->label('Gudang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'requested' => 'warning',
                        'issued' => 'success',
                        default => 'gray',
                    }),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMaterialRequests::route('/'),
            'create' => Pages\CreateMaterialRequest::route('/create'),
            'edit' => Pages\EditMaterialRequest::route('/{record}/edit'),
        ];
    }
}
