<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = '🏢 Tenants';
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?int $navigationSort = 5;
    protected static ?string $modelLabel = 'Pengguna';
    protected static ?string $pluralModelLabel = 'Pengguna';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tenant_id')
                    ->relationship('tenant', 'name')
                    ->label('Tenant')
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('company_id')
                    ->relationship('company', 'name')
                    ->label('Perusahaan')
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->label('Email'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn($state) => $state ? Hash::make($state) : null)
                    ->dehydrated(fn($state) => filled($state))
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->maxLength(255)
                    ->label('Password'),
                Forms\Components\Select::make('role')
                    ->options(collect(UserRole::cases())->mapWithKeys(fn($r) => [$r->value => $r->label()]))
                    ->required()
                    ->label('Role'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->formatStateUsing(fn(?string $state): string => UserRole::tryFrom($state)?->label() ?? $state ?? '-')
                    ->color(fn(?string $state): string => match ($state) {
                        'super_admin' => 'danger',
                        'platform_admin' => 'danger',
                        'platform_support' => 'info',
                        'platform_billing' => 'warning',
                        'owner' => 'gray',
                        'admin' => 'info',
                        'finance' => 'success',
                        'accounting' => 'success',
                        'sales' => 'primary',
                        'purchasing' => 'primary',
                        'warehouse' => 'warning',
                        'production' => 'warning',
                        'cashier' => 'success',
                        'auditor' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('last_login_at')
                    ->label('Login Terakhir')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
