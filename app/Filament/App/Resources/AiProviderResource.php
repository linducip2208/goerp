<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\AiProviderResource\Pages;
use App\Models\AiProvider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AiProviderResource extends Resource
{
    protected static ?string $model = AiProvider::class;

    protected static ?string $navigationGroup = '⚙️ Pengaturan';
    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';
    protected static ?int $navigationSort = 173;
    protected static ?string $modelLabel = 'Provider AI';
    protected static ?string $pluralModelLabel = 'Provider AI';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama'),
                Forms\Components\Select::make('api_format')
                    ->required()
                    ->options([
                        'openai_compatible' => 'OpenAI Compatible',
                        'anthropic' => 'Anthropic',
                        'gemini' => 'Gemini',
                    ])
                    ->default('openai_compatible')
                    ->label('Format API'),
                Forms\Components\TextInput::make('base_url')
                    ->maxLength(255)
                    ->url()
                    ->label('Base URL'),
                Forms\Components\TextInput::make('api_key_encrypted')
                    ->password()
                    ->maxLength(255)
                    ->label('API Key'),
                Forms\Components\TextInput::make('default_model')
                    ->maxLength(255)
                    ->label('Default Model'),
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
                Tables\Columns\TextColumn::make('api_format')
                    ->label('Format API')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'openai_compatible' => 'success',
                        'anthropic' => 'info',
                        'gemini' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('base_url')
                    ->label('Base URL')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('default_model')
                    ->label('Default Model'),
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
            'index' => Pages\ListAiProviders::route('/'),
            'create' => Pages\CreateAiProvider::route('/create'),
            'edit' => Pages\EditAiProvider::route('/{record}/edit'),
        ];
    }
}
