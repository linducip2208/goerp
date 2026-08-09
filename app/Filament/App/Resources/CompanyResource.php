<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\CompanyResource\Pages;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationGroup = '⚙️ Pengaturan';
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?int $navigationSort = 150;
    protected static ?string $modelLabel = 'Perusahaan';
    protected static ?string $pluralModelLabel = 'Perusahaan';

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
                    ->required()
                    ->maxLength(255)
                    ->label('Kode'),
                Forms\Components\TextInput::make('npwp')
                    ->maxLength(255)
                    ->label('NPWP'),
                Forms\Components\TextInput::make('nib')
                    ->maxLength(255)
                    ->label('NIB'),
                Forms\Components\Textarea::make('address')
                    ->columnSpanFull()
                    ->label('Alamat'),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255)
                    ->label('Telepon'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255)
                    ->label('Email'),
                Forms\Components\TextInput::make('logo')
                    ->maxLength(255)
                    ->label('Logo'),
                Forms\Components\TextInput::make('timezone')
                    ->required()
                    ->maxLength(255)
                    ->default('Asia/Jakarta')
                    ->label('Zona Waktu'),
                Forms\Components\TextInput::make('date_format')
                    ->required()
                    ->maxLength(255)
                    ->default('d/m/Y')
                    ->label('Format Tanggal'),
                Forms\Components\TextInput::make('fiscal_year_start')
                    ->required()
                    ->numeric()
                    ->default(1)
                    ->label('Awal Tahun Fiskal'),
                Forms\Components\TextInput::make('base_currency')
                    ->required()
                    ->maxLength(255)
                    ->default('IDR')
                    ->label('Mata Uang'),
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
                Tables\Columns\TextColumn::make('npwp')
                    ->label('NPWP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telepon'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email'),
                Tables\Columns\TextColumn::make('timezone')
                    ->label('Zona Waktu'),
                Tables\Columns\TextColumn::make('base_currency')
                    ->label('Mata Uang'),
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
