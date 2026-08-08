<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BackupLogResource\Pages;
use App\Models\BackupLog;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BackupLogResource extends Resource
{
    protected static ?string $model = BackupLog::class;

    protected static ?string $navigationGroup = '🛠️ System';
    protected static ?string $navigationIcon = 'heroicon-o-server-stack';
    protected static ?int $navigationSort = 179;
    protected static ?string $modelLabel = 'Log Backup';
    protected static ?string $pluralModelLabel = 'Log Backup';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('filename')
                    ->label('Nama File')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('size_bytes')
                    ->label('Ukuran')
                    ->formatStateUsing(fn(int $state): string => number_format($state / 1024 / 1024, 2) . ' MB')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'success' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('error_message')
                    ->label('Error')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListBackupLogs::route('/'),
        ];
    }
}
