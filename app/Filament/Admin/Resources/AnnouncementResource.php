<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AnnouncementResource\Pages;
use App\Models\Announcement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static ?string $navigationGroup = '📢 Announcements';
    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Pengumuman';
    protected static ?string $pluralModelLabel = 'Pengumuman';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('content')
                    ->label('Konten')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('target')
                    ->label('Target')
                    ->options([
                        'all' => 'Semua Tenant',
                        'specific_tenant' => 'Tenant Tertentu',
                        'plan' => 'Berdasarkan Paket',
                    ])
                    ->required()
                    ->default('all'),
                Forms\Components\TextInput::make('target_id')
                    ->label('Target ID')
                    ->numeric(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
                Forms\Components\DateTimePicker::make('published_at')
                    ->label('Dipublikasi Pada'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('target')
                    ->colors([
                        'info' => 'all',
                        'warning' => 'specific_tenant',
                        'success' => 'plan',
                    ]),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Aktif'),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit' => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }
}
