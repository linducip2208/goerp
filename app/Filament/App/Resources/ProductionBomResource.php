<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\ProductionBomResource\Pages;
use App\Filament\App\Resources\ProductionBomResource\RelationManagers\ItemsRelationManager;
use App\Models\ProductionBom;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductionBomResource extends Resource
{
    protected static ?string $model = ProductionBom::class;

    protected static ?string $navigationGroup = '🏭 Manufaktur';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?int $navigationSort = 70;
    protected static ?string $modelLabel = 'Bill of Materials';
    protected static ?string $pluralModelLabel = 'Bill of Materials';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Hidden::make('company_id'),
                Forms\Components\Select::make('product_variant_id')
                    ->relationship('productVariant', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Produk Jadi'),
                Forms\Components\TextInput::make('bom_no')
                    ->required()
                    ->maxLength(255)
                    ->label('No. BOM'),
                Forms\Components\TextInput::make('version')
                    ->required()
                    ->numeric()
                    ->default(1)
                    ->label('Versi'),
                Forms\Components\TextInput::make('expected_output')
                    ->required()
                    ->numeric()
                    ->label('Output Ekspektasi'),
                Forms\Components\TextInput::make('waste_percent')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->suffix('%')
                    ->label('Persen Limbah'),
                Forms\Components\TextInput::make('standard_labor_cost')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->prefix('Rp')
                    ->label('Biaya Tenaga Kerja'),
                Forms\Components\TextInput::make('standard_overhead')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->prefix('Rp')
                    ->label('Biaya Overhead'),
                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->label('Aktif'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('bom_no')
                    ->label('No. BOM')
                    ->searchable(),
                Tables\Columns\TextColumn::make('productVariant.name')
                    ->label('Produk Jadi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('version')
                    ->label('Versi')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expected_output')
                    ->label('Output Ekspektasi')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('waste_percent')
                    ->label('Limbah')
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('standard_labor_cost')
                    ->label('Biaya Kerja')
                    ->money('IDR')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('standard_overhead')
                    ->label('Overhead')
                    ->money('IDR')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
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
            ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductionBoms::route('/'),
            'create' => Pages\CreateProductionBom::route('/create'),
            'edit' => Pages\EditProductionBom::route('/{record}/edit'),
        ];
    }
}
