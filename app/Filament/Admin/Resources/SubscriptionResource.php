<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SubscriptionResource\Pages;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\Tenant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationGroup = '💳 Subscriptions';
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Langganan';
    protected static ?string $pluralModelLabel = 'Langganan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tenant_id')
                    ->label('Tenant')
                    ->options(Tenant::pluck('name', 'id'))
                    ->required()
                    ->searchable(),
                Forms\Components\Select::make('plan_id')
                    ->label('Paket')
                    ->options(SubscriptionPlan::where('is_active', true)->pluck('name', 'id'))
                    ->required()
                    ->searchable(),
                Forms\Components\DatePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                    ->label('Tanggal Berakhir')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'trial' => 'Trial',
                        'active' => 'Active',
                        'due' => 'Due',
                        'grace' => 'Grace',
                        'suspended' => 'Suspended',
                    ])
                    ->required()
                    ->default('trial'),
                Forms\Components\Toggle::make('auto_renew')
                    ->label('Auto Renew')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tenant.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('plan.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'gray' => 'trial',
                        'success' => 'active',
                        'warning' => 'due',
                        'warning' => 'grace',
                        'danger' => 'suspended',
                    ]),
                Tables\Columns\IconColumn::make('auto_renew')
                    ->boolean()
                    ->label('Auto Renew'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
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
            \App\Filament\Admin\Resources\SubscriptionResource\RelationManagers\InvoicesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
