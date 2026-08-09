<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\LockPeriodResource\Pages;
use App\Models\LockPeriod;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LockPeriodResource extends Resource
{
    protected static ?string $model = LockPeriod::class;

    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationGroup = null;
    protected static ?int $navigationSort = 999;
    protected static ?string $modelLabel = 'Lock Period';
    protected static ?string $pluralModelLabel = 'Lock Period';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Hidden::make('company_id'),
                Forms\Components\TextInput::make('period')
                    ->required()
                    ->label('Periode (YYYY-MM)')
                    ->placeholder('YYYY-MM')
                    ->rule('regex:/^\d{4}-\d{2}$/')
                    ->maxLength(7),
                Forms\Components\Hidden::make('locked_by'),
                Forms\Components\Hidden::make('locked_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('period')
                    ->label('Periode')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Perusahaan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('lockedBy.name')
                    ->label('Dikunci Oleh')
                    ->default('-'),
                Tables\Columns\TextColumn::make('locked_at')
                    ->label('Waktu Kunci')
                    ->dateTime()
                    ->sortable()
                    ->default('-'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('lock_period')
                    ->label('Kunci Periode')
                    ->icon('heroicon-o-lock-closed')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Kunci Periode')
                    ->modalDescription('Yakin ingin mengunci periode ini? Jurnal pada periode ini tidak bisa diedit setelah dikunci.')
                    ->modalSubmitActionLabel('Ya, Kunci')
                    ->action(function (LockPeriod $record) {
                        $record->update([
                            'locked_by' => auth()->id(),
                            'locked_at' => now(),
                        ]);
                        Notification::make()
                            ->title('Periode ' . $record->period . ' berhasil dikunci')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (LockPeriod $record) => is_null($record->locked_at)),
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
            'index' => Pages\ListLockPeriods::route('/'),
            'create' => Pages\CreateLockPeriod::route('/create'),
            'edit' => Pages\EditLockPeriod::route('/{record}/edit'),
        ];
    }
}
