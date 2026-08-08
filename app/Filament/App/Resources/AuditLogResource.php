<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\AuditLogResource\Pages;
use App\Models\AuditLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AuditLogResource extends Resource
{
    protected static ?string $model = AuditLog::class;

    protected static ?string $navigationGroup = '🔐 Security & Audit';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?int $navigationSort = 92;
    protected static ?string $modelLabel = 'Audit Trail';
    protected static ?string $pluralModelLabel = 'Audit Trail';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi')
                    ->schema([
                        Forms\Components\Placeholder::make('user_name')
                            ->label('User')
                            ->content(fn($record) => $record->user?->name ?? 'System'),
                        Forms\Components\Placeholder::make('action')
                            ->label('Aksi')
                            ->content(fn($record) => $record->action),
                        Forms\Components\Placeholder::make('module')
                            ->label('Modul')
                            ->content(fn($record) => $record->module),
                        Forms\Components\Placeholder::make('document_type')
                            ->label('Tipe Dokumen')
                            ->content(fn($record) => $record->document_type),
                        Forms\Components\Placeholder::make('document_no')
                            ->label('No. Dokumen')
                            ->content(fn($record) => $record->document_no),
                        Forms\Components\Placeholder::make('ip_address')
                            ->label('IP Address')
                            ->content(fn($record) => $record->ip_address),
                        Forms\Components\Placeholder::make('user_agent')
                            ->label('User Agent')
                            ->content(fn($record) => $record->user_agent),
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Waktu')
                            ->content(fn($record) => $record->created_at?->format('d M Y H:i:s')),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Perubahan Data')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\ViewEntry::make('old_values')
                                    ->label('Data Lama')
                                    ->view('filament.components.code-block', [
                                        'data' => fn($record) => $record->old_values,
                                    ]),
                                Forms\Components\ViewEntry::make('new_values')
                                    ->label('Data Baru')
                                    ->view('filament.components.code-block', [
                                        'data' => fn($record) => $record->new_values,
                                    ]),
                            ]),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('action')
                    ->label('Aksi')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'create' => 'success',
                        'update' => 'warning',
                        'delete' => 'danger',
                        'post' => 'info',
                        'approve' => 'success',
                        'reject' => 'danger',
                        'login' => 'gray',
                        'export' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('module')
                    ->label('Modul')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('document_type')
                    ->label('Tipe Dokumen')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('document_no')
                    ->label('No. Dokumen')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('module')
                    ->label('Modul')
                    ->options(fn() => AuditLog::query()->distinct()->pluck('module', 'module')->toArray()),
                Tables\Filters\SelectFilter::make('action')
                    ->label('Aksi')
                    ->options([
                        'create' => 'Create',
                        'update' => 'Update',
                        'delete' => 'Delete',
                        'post' => 'Post',
                        'approve' => 'Approve',
                        'reject' => 'Reject',
                        'login' => 'Login',
                        'export' => 'Export',
                    ]),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Dari'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Sampai'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['created_from'], fn($q, $d) => $q->whereDate('created_at', '>=', $d))
                            ->when($data['created_until'], fn($q, $d) => $q->whereDate('created_at', '<=', $d));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuditLogs::route('/'),
            'view' => Pages\ViewAuditLog::route('/{record}'),
        ];
    }
}
