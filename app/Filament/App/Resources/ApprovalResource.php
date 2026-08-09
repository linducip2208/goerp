<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\ApprovalResource\Pages;
use App\Models\Approval;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class ApprovalResource extends Resource
{
    protected static ?string $model = Approval::class;

    protected static ?string $navigationGroup = '⚙️ Pengaturan';
    protected static ?string $navigationIcon = 'heroicon-o-check-badge';
    protected static ?int $navigationSort = 159;
    protected static ?string $modelLabel = 'Approval';
    protected static ?string $pluralModelLabel = 'Approval';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Approval')
                    ->schema([
                        Forms\Components\Placeholder::make('approvable_type')
                            ->label('Tipe Dokumen')
                            ->content(fn($record) => $record->approvable_type),
                        Forms\Components\Placeholder::make('document_no')
                            ->label('No. Dokumen')
                            ->content(fn($record) => $record->document_no),
                        Forms\Components\Placeholder::make('status')
                            ->label('Status')
                            ->content(fn($record) => strtoupper($record->status)),
                        Forms\Components\Placeholder::make('submitted_by')
                            ->label('Diajukan Oleh')
                            ->content(fn($record) => $record->submittedBy?->name),
                        Forms\Components\Placeholder::make('submitted_at')
                            ->label('Tanggal Ajuan')
                            ->content(fn($record) => $record->submitted_at?->translatedFormat('d M Y H:i')),
                        Forms\Components\Placeholder::make('approved_by')
                            ->label('Diputuskan Oleh')
                            ->content(fn($record) => $record->approvedBy?->name),
                        Forms\Components\Placeholder::make('approved_at')
                            ->label('Tanggal Keputusan')
                            ->content(fn($record) => $record->approved_at?->translatedFormat('d M Y H:i')),
                        Forms\Components\Placeholder::make('rejected_reason')
                            ->label('Alasan Penolakan')
                            ->content(fn($record) => $record->rejected_reason)
                            ->visible(fn($record) => $record->status === 'rejected'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('approvable_type')
                    ->label('Tipe Dokumen')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('document_no')
                    ->label('No. Dokumen')
                    ->searchable()
                    ->state(fn($record) => $record->document_no),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'submitted' => 'warning',
                        'waiting' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'posted' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('submittedBy.name')
                    ->label('Diajukan Oleh')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('Tgl Ajuan')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('approvedBy.name')
                    ->label('Diputuskan Oleh')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('approved_at')
                    ->label('Tgl Keputusan')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'submitted' => 'Submitted',
                        'waiting' => 'Waiting',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'posted' => 'Posted',
                    ]),
                Tables\Filters\SelectFilter::make('approvable_type')
                    ->options([
                        'SalesInvoice' => 'Faktur Penjualan',
                        'PurchaseOrder' => 'Purchase Order',
                        'JournalEntry' => 'Jurnal',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function (Approval $record) {
                        $record->approvable->approve();
                        Notification::make()
                            ->title('Approval disetujui')
                            ->success()
                            ->send();
                    })
                    ->visible(fn(Approval $record) => in_array($record->status, ['submitted', 'waiting']))
                    ->requiresConfirmation(),
                Tables\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->form([
                        Forms\Components\Textarea::make('reason')
                            ->label('Alasan Penolakan')
                            ->required(),
                    ])
                    ->action(function (Approval $record, array $data) {
                        $record->approvable->reject($data['reason']);
                        Notification::make()
                            ->title('Approval ditolak')
                            ->success()
                            ->send();
                    })
                    ->visible(fn(Approval $record) => in_array($record->status, ['submitted', 'waiting']))
                    ->modalHeading('Tolak Approval')
                    ->modalSubmitActionLabel('Tolak'),
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
            'index' => Pages\ListApprovals::route('/'),
            'view' => Pages\ViewApproval::route('/{record}'),
        ];
    }
}
