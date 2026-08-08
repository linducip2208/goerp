<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\OpportunityResource\Pages;
use App\Models\Opportunity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OpportunityResource extends Resource
{
    protected static ?string $model = Opportunity::class;

    protected static ?string $navigationGroup = '👥 CRM';
    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?int $navigationSort = 102;
    protected static ?string $modelLabel = 'Peluang';
    protected static ?string $pluralModelLabel = 'Peluang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Peluang'),
                Forms\Components\Select::make('contact_id')
                    ->relationship('contact', 'name')
                    ->searchable()
                    ->required()
                    ->label('Kontak'),
                Forms\Components\Select::make('lead_id')
                    ->relationship('lead', 'name')
                    ->searchable()
                    ->label('Prospek'),
                Forms\Components\Select::make('stage')
                    ->required()
                    ->options([
                        'prospecting' => 'Prospek',
                        'qualification' => 'Kualifikasi',
                        'needs_analysis' => 'Analisis Kebutuhan',
                        'proposal' => 'Proposal',
                        'negotiation' => 'Negosiasi',
                        'closed_won' => 'Menang',
                        'closed_lost' => 'Kalah',
                    ])
                    ->default('prospecting')
                    ->label('Tahap'),
                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->label('Nilai'),
                Forms\Components\DatePicker::make('close_date')
                    ->label('Tgl Penutupan'),
                Forms\Components\TextInput::make('probability')
                    ->integer()
                    ->minValue(0)
                    ->maxValue(100)
                    ->default(0)
                    ->label('Probabilitas (%)'),
                Forms\Components\Select::make('assigned_to')
                    ->relationship('assignedUser', 'name')
                    ->searchable()
                    ->label('Ditugaskan ke'),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull()
                    ->label('Catatan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Peluang')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('contact.name')
                    ->label('Kontak')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stage')
                    ->label('Tahap')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'closed_won' => 'success',
                        'closed_lost' => 'danger',
                        'prospecting', 'qualification' => 'warning',
                        'needs_analysis', 'proposal', 'negotiation' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Nilai')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('probability')
                    ->label('Probabilitas')
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('close_date')
                    ->label('Tgl Penutupan')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('assignedUser.name')
                    ->label('Ditugaskan ke'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('stage')
                    ->label('Tahap'),
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
            'index' => Pages\ListOpportunities::route('/'),
            'create' => Pages\CreateOpportunity::route('/create'),
            'edit' => Pages\EditOpportunity::route('/{record}/edit'),
        ];
    }
}
