<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\ImportHistoryResource\Pages;
use App\Models\ImportHistory;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ImportHistoryResource extends Resource
{
    protected static ?string $model = ImportHistory::class;

    protected static ?string $navigationGroup = '⚙️ Pengaturan';
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?int $navigationSort = 165;
    protected static ?string $modelLabel = 'Riwayat Impor';
    protected static ?string $pluralModelLabel = 'Riwayat Impor';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('import_type')
                    ->label('Tipe Impor')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('filename')
                    ->label('Nama File')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_rows')
                    ->label('Total Baris')
                    ->sortable(),
                Tables\Columns\TextColumn::make('imported_rows')
                    ->label('Berhasil')
                    ->sortable(),
                Tables\Columns\TextColumn::make('failed_rows')
                    ->label('Gagal')
                    ->sortable(),
                Tables\Columns\TextColumn::make('importer.name')
                    ->label('Diimpor oleh'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('import_type')
                    ->label('Tipe Impor'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                //
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
            'index' => Pages\ListImportHistories::route('/'),
        ];
    }
}
