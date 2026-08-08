<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationGroup = '📚 Master Data';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 14;
    protected static ?string $modelLabel = 'Kontak';
    protected static ?string $pluralModelLabel = 'Kontak';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Hidden::make('company_id'),
                Forms\Components\Select::make('type')
                    ->required()
                    ->options([
                        'customer' => 'Customer',
                        'supplier' => 'Supplier',
                        'employee' => 'Karyawan',
                        'other' => 'Lainnya',
                    ])
                    ->label('Tipe'),
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255)
                    ->label('Kode'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama'),
                Forms\Components\TextInput::make('company_name')
                    ->maxLength(255)
                    ->label('Nama Perusahaan'),
                Forms\Components\TextInput::make('npwp')
                    ->maxLength(255)
                    ->label('NPWP'),
                Forms\Components\TextInput::make('nik')
                    ->maxLength(255)
                    ->label('NIK'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255)
                    ->label('Email'),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255)
                    ->label('Telepon'),
                Forms\Components\Textarea::make('address')
                    ->columnSpanFull()
                    ->label('Alamat'),
                Forms\Components\TextInput::make('payment_term_days')
                    ->numeric()
                    ->label('Term Pembayaran (hari)'),
                Forms\Components\TextInput::make('credit_limit')
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Batas Kredit'),
                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->label('Aktif'),
                Forms\Components\Section::make('Portal Akses')
                    ->schema([
                        Forms\Components\Toggle::make('portal_access')
                            ->label('Akses Portal')
                            ->helperText('Aktifkan agar customer bisa login ke portal')
                            ->live(),
                        Forms\Components\TextInput::make('portal_password')
                            ->label('Password Portal')
                            ->password()
                            ->revealable()
                            ->helperText('Kosongkan untuk generate password otomatis')
                            ->visible(fn(Forms\Get $get) => $get('portal_access')),
                    ])
                    ->visible(fn(Forms\Get $get) => $get('type') === 'customer'),
            ]);
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        if ($data['type'] === 'customer' && ($data['portal_access'] ?? false) && empty($data['portal_password'] ?? null)) {
            $data['portal_password'] = \Illuminate\Support\Facades\Hash::make(Str::random(10));
        } elseif (!empty($data['portal_password'] ?? null)) {
            $data['portal_password'] = \Illuminate\Support\Facades\Hash::make($data['portal_password']);
        }

        return $data;
    }

    public static function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['type'] === 'customer' && ($data['portal_access'] ?? false) && empty($data['portal_password'] ?? null)) {
            $data['portal_password'] = \Illuminate\Support\Facades\Hash::make(Str::random(10));
        } elseif (!empty($data['portal_password'] ?? null) && !\Illuminate\Support\Facades\Hash::isHashed($data['portal_password'])) {
            $data['portal_password'] = \Illuminate\Support\Facades\Hash::make($data['portal_password']);
        }

        return $data;
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
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'customer' => 'success',
                        'supplier' => 'warning',
                        'employee' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('company_name')
                    ->label('Perusahaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telepon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('credit_limit')
                    ->label('Batas Kredit')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
