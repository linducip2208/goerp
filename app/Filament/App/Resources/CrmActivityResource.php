<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\CrmActivityResource\Pages;
use App\Models\CrmActivity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CrmActivityResource extends Resource
{
    protected static ?string $model = CrmActivity::class;

    protected static ?string $navigationGroup = null;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $modelLabel = 'Aktivitas';
    protected static ?string $pluralModelLabel = 'Aktivitas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Select::make('contact_id')
                    ->relationship('contact', 'name')
                    ->searchable()
                    ->required()
                    ->label('Kontak'),
                Forms\Components\Select::make('lead_id')
                    ->relationship('lead', 'name')
                    ->searchable()
                    ->label('Prospek'),
                Forms\Components\Select::make('type')
                    ->required()
                    ->options([
                        'call' => 'Telepon',
                        'meeting' => 'Pertemuan',
                        'email' => 'Email',
                        'follow_up' => 'Follow Up',
                        'note' => 'Catatan',
                    ])
                    ->label('Tipe'),
                Forms\Components\TextInput::make('subject')
                    ->required()
                    ->maxLength(255)
                    ->label('Subjek'),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull()
                    ->label('Deskripsi'),
                Forms\Components\DateTimePicker::make('activity_date')
                    ->required()
                    ->label('Tgl Aktivitas'),
                Forms\Components\Select::make('assigned_to')
                    ->relationship('assignedUser', 'name')
                    ->searchable()
                    ->label('Ditugaskan ke'),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'planned' => 'Direncanakan',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ])
                    ->default('planned')
                    ->label('Status'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subject')
                    ->label('Subjek')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('contact.name')
                    ->label('Kontak')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'call' => 'success',
                        'meeting' => 'info',
                        'email' => 'warning',
                        'follow_up' => 'primary',
                        'note' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('activity_date')
                    ->label('Tgl Aktivitas')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('assignedUser.name')
                    ->label('Ditugaskan ke'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'planned' => 'warning',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipe'),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status'),
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
            'index' => Pages\ListCrmActivities::route('/'),
            'create' => Pages\CreateCrmActivity::route('/create'),
            'edit' => Pages\EditCrmActivity::route('/{record}/edit'),
        ];
    }
}
