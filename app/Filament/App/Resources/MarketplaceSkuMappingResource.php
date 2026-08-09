<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\MarketplaceSkuMappingResource\Pages;
use App\Models\MarketplaceSkuMapping;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MarketplaceSkuMappingResource extends Resource
{
    protected static ?string $model = MarketplaceSkuMapping::class;

    protected static ?string $navigationGroup = 'Operasional';
    protected static ?string $navigationIcon = 'heroicon-o-link';
    protected static ?int $navigationSort = 49;
    protected static ?string $modelLabel = 'Mapping SKU';
    protected static ?string $pluralModelLabel = 'Mapping SKU';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Select::make('marketplace')
                    ->options([
                        'shopee' => 'Shopee',
                        'tiktok' => 'TikTok Shop',
                        'lazada' => 'Lazada',
                    ])
                    ->required()
                    ->label('Marketplace'),
                Forms\Components\TextInput::make('marketplace_sku')
                    ->required()
                    ->maxLength(255)
                    ->label('Marketplace SKU'),
                Forms\Components\Select::make('product_variant_id')
                    ->relationship('productVariant', 'internal_sku')
                    ->searchable()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->internal_sku . ' — ' . ($record->name ?? $record->product?->name))
                    ->required()
                    ->label('Produk Internal'),
                Forms\Components\Toggle::make('is_auto')
                    ->label('Auto Mapping')
                    ->helperText('Centang jika mapping ini dibuat otomatis oleh sistem'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('marketplace')
                    ->label('Marketplace')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'shopee' => 'danger',
                        'tiktok' => 'info',
                        'lazada' => 'primary',
                        default => 'gray',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('marketplace_sku')
                    ->label('Marketplace SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('productVariant.internal_sku')
                    ->label('Internal SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('productVariant.name')
                    ->label('Nama Produk')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_auto')
                    ->label('Auto')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('marketplace')
                    ->options([
                        'shopee' => 'Shopee',
                        'tiktok' => 'TikTok Shop',
                        'lazada' => 'Lazada',
                    ])
                    ->label('Marketplace'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListMarketplaceSkuMappings::route('/'),
            'create' => Pages\CreateMarketplaceSkuMapping::route('/create'),
            'edit' => Pages\EditMarketplaceSkuMapping::route('/{record}/edit'),
        ];
    }
}
