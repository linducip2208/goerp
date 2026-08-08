<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SubscriptionPlanResource\Pages;
use App\Models\SubscriptionPlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SubscriptionPlanResource extends Resource
{
    protected static ?string $model = SubscriptionPlan::class;

    protected static ?string $navigationGroup = '💳 Subscriptions';
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Paket Langganan';
    protected static ?string $pluralModelLabel = 'Paket Langganan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('name')
                    ->options([
                        'Starter' => 'Starter',
                        'Pro' => 'Pro',
                        'Business' => 'Business',
                        'Enterprise' => 'Enterprise',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('price_monthly')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0),
                Forms\Components\TextInput::make('price_yearly')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0),
                Forms\Components\TextInput::make('max_users')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\TextInput::make('max_companies')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\TextInput::make('max_branches')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\TextInput::make('max_warehouses')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\KeyValue::make('features')
                    ->label('Fitur')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price_monthly')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_yearly')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_users')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Aktif'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptionPlans::route('/'),
            'create' => Pages\CreateSubscriptionPlan::route('/create'),
            'edit' => Pages\EditSubscriptionPlan::route('/{record}/edit'),
        ];
    }
}
