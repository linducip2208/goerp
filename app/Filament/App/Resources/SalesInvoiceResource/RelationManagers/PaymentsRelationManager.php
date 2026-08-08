<?php

namespace App\Filament\App\Resources\SalesInvoiceResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    protected static ?string $title = 'Pembayaran';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('payment_no')
                    ->label('No. Pembayaran')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('payment_date')
                    ->label('Tanggal Bayar')
                    ->default(now())
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->label('Jumlah')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),
                Forms\Components\Select::make('method')
                    ->label('Metode')
                    ->options([
                        'cash' => 'Cash',
                        'transfer' => 'Transfer',
                        'giro' => 'Giro',
                        'other' => 'Lainnya',
                    ])
                    ->required()
                    ->default('transfer'),
                Forms\Components\Select::make('bank_account_id')
                    ->label('Rekening Bank')
                    ->relationship('bankAccount', 'account_name')
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('reference')
                    ->label('Referensi')
                    ->maxLength(255),
                Forms\Components\Textarea::make('notes')
                    ->label('Catatan')
                    ->rows(3)
                    ->maxLength(500),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('payment_no')
            ->columns([
                Tables\Columns\TextColumn::make('payment_no')
                    ->label('No. Pembayaran')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('method')
                    ->label('Metode')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'cash' => 'success',
                        'transfer' => 'info',
                        'giro' => 'warning',
                        'other' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'cash' => 'Cash',
                        'transfer' => 'Transfer',
                        'giro' => 'Giro',
                        'other' => 'Lainnya',
                        default => $state,
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('reference')
                    ->label('Referensi')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Pembayaran'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
