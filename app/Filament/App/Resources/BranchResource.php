<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\BranchResource\Pages;
use App\Models\Branch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;

    protected static ?string $navigationGroup = '⚙️ Pengaturan';
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?int $navigationSort = 151;
    protected static ?string $modelLabel = 'Cabang';
    protected static ?string $pluralModelLabel = 'Cabang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('company_id')
                    ->relationship('company', 'name')
                    ->searchable()
                    ->required()
                    ->label('Perusahaan'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama'),
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255)
                    ->label('Kode'),
                Forms\Components\Textarea::make('address')
                    ->columnSpanFull()
                    ->label('Alamat'),
                Forms\Components\TextInput::make('pic_name')
                    ->maxLength(255)
                    ->label('Nama PIC'),
                Forms\Components\TextInput::make('pic_phone')
                    ->tel()
                    ->maxLength(255)
                    ->label('Telepon PIC'),
                Forms\Components\Select::make('default_warehouse_id')
                    ->relationship('defaultWarehouse', 'name')
                    ->label('Gudang Default'),
                Forms\Components\Toggle::make('is_active')
                    ->required()
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
                    ->searchable(),
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Perusahaan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pic_name')
                    ->label('PIC'),
                Tables\Columns\TextColumn::make('pic_phone')
                    ->label('Telepon'),
                Tables\Columns\TextColumn::make('defaultWarehouse.name')
                    ->label('Gudang Default'),
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
            'index' => Pages\ListBranches::route('/'),
            'create' => Pages\CreateBranch::route('/create'),
            'edit' => Pages\EditBranch::route('/{record}/edit'),
        ];
    }
}
