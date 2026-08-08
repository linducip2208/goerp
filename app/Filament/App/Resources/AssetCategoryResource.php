<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\AssetCategoryResource\Pages;
use App\Models\AssetCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AssetCategoryResource extends Resource
{
    protected static ?string $model = AssetCategory::class;

    protected static ?string $navigationGroup = '🏦 Asset';
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?int $navigationSort = 102;
    protected static ?string $modelLabel = 'Kategori Aset';
    protected static ?string $pluralModelLabel = 'Kategori Aset';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama'),
                Forms\Components\TextInput::make('code')
                    ->maxLength(255)
                    ->label('Kode'),
                Forms\Components\TextInput::make('useful_life_months')
                    ->required()
                    ->integer()
                    ->default(0)
                    ->label('Umur Ekonomis (bulan)'),
                Forms\Components\Select::make('depreciation_method')
                    ->required()
                    ->options([
                        'straight_line' => 'Garis Lurus',
                        'double_declining' => 'Saldo Menurun',
                    ])
                    ->label('Metode Penyusutan'),
                Forms\Components\Select::make('asset_account_id')
                    ->relationship('assetAccount', 'name')
                    ->searchable()
                    ->label('Akun Aset'),
                Forms\Components\Select::make('accum_depr_account_id')
                    ->relationship('accumDeprAccount', 'name')
                    ->searchable()
                    ->label('Akun Akumulasi Penyusutan'),
                Forms\Components\Select::make('expense_account_id')
                    ->relationship('expenseAccount', 'name')
                    ->searchable()
                    ->label('Akun Beban Penyusutan'),
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
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('useful_life_months')
                    ->label('Umur (bln)')
                    ->sortable(),
                Tables\Columns\TextColumn::make('depreciation_method')
                    ->label('Metode')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'straight_line' => 'info',
                        'double_declining' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('fixed_assets_count')
                    ->label('Jumlah Aset')
                    ->counts('fixedAssets'),
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
            'index' => Pages\ListAssetCategories::route('/'),
            'create' => Pages\CreateAssetCategory::route('/create'),
            'edit' => Pages\EditAssetCategory::route('/{record}/edit'),
        ];
    }
}
