<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportTemplateResource\Pages;
use App\Models\ReportTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReportTemplateResource extends Resource
{
    protected static ?string $model = ReportTemplate::class;

    protected static ?string $navigationGroup = '📈 Reports';
    protected static ?string $navigationIcon = 'heroicon-o-document-plus';
    protected static ?int $navigationSort = 77;
    protected static ?string $modelLabel = 'Template Laporan';
    protected static ?string $pluralModelLabel = 'Template Laporan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama'),
                Forms\Components\Select::make('type')
                    ->required()
                    ->options([
                        'sales' => 'Penjualan',
                        'purchase' => 'Pembelian',
                        'inventory' => 'Inventory',
                        'accounting' => 'Akuntansi',
                        'custom' => 'Custom',
                    ])
                    ->label('Tipe'),
                Forms\Components\Textarea::make('config')
                    ->columnSpanFull()
                    ->label('Konfigurasi (JSON)'),
                Forms\Components\Toggle::make('is_public')
                    ->required()
                    ->default(false)
                    ->label('Publik'),
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
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'sales' => 'success',
                        'purchase' => 'info',
                        'inventory' => 'warning',
                        'accounting' => 'primary',
                        'custom' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_public')
                    ->label('Publik')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipe'),
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
            'index' => Pages\ListReportTemplates::route('/'),
            'create' => Pages\CreateReportTemplate::route('/create'),
            'edit' => Pages\EditReportTemplate::route('/{record}/edit'),
        ];
    }
}
