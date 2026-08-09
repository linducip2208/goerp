<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\PettyCashResource\Pages;
use App\Models\PettyCash;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PettyCashResource extends Resource
{
    protected static ?string $model = PettyCash::class;

    protected static ?string $navigationGroup = '💵 Keuangan';
    protected static ?string $navigationIcon = 'heroicon-o-wallet';
    protected static ?int $navigationSort = 93;
    protected static ?string $modelLabel = 'Kas Kecil';
    protected static ?string $pluralModelLabel = 'Kas Kecil';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Hidden::make('company_id'),
                Forms\Components\TextInput::make('transaction_no')
                    ->required()
                    ->maxLength(255)
                    ->label('No. Transaksi'),
                Forms\Components\DatePicker::make('transaction_date')
                    ->required()
                    ->label('Tgl Transaksi'),
                Forms\Components\Select::make('type')
                    ->required()
                    ->options([
                        'top_up' => 'Top Up',
                        'expense' => 'Pengeluaran',
                    ])
                    ->label('Tipe'),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->label('Jumlah'),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull()
                    ->label('Deskripsi'),
                Forms\Components\Select::make('account_id')
                    ->relationship('account', 'name')
                    ->searchable()
                    ->required()
                    ->label('Akun'),
                Forms\Components\Select::make('requested_by')
                    ->relationship('requester', 'name')
                    ->searchable()
                    ->required()
                    ->label('Diminta oleh'),
                Forms\Components\Select::make('approved_by')
                    ->relationship('approver', 'name')
                    ->searchable()
                    ->label('Disetujui oleh'),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'draft' => 'Draft',
                        'approved' => 'Disetujui',
                        'closed' => 'Ditutup',
                    ])
                    ->default('draft')
                    ->label('Status'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transaction_no')
                    ->label('No. Transaksi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('transaction_date')
                    ->label('Tgl')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'top_up' => 'success',
                        'expense' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('account.name')
                    ->label('Akun'),
                Tables\Columns\TextColumn::make('requester.name')
                    ->label('Peminta'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'warning',
                        'approved' => 'info',
                        'closed' => 'success',
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
            'index' => Pages\ListPettyCashes::route('/'),
            'create' => Pages\CreatePettyCash::route('/create'),
            'edit' => Pages\EditPettyCash::route('/{record}/edit'),
        ];
    }
}
