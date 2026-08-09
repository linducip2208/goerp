<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\SalesReturnResource\Pages;
use App\Models\SalesReturn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SalesReturnResource extends Resource
{
    protected static ?string $model = SalesReturn::class;

    protected static ?string $navigationGroup = '💰 Penjualan';
    protected static ?string $navigationIcon = 'heroicon-o-arrow-uturn-left';
    protected static ?int $navigationSort = 34;
    protected static ?string $modelLabel = 'Retur Penjualan';
    protected static ?string $pluralModelLabel = 'Retur Penjualan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Hidden::make('company_id'),
                Forms\Components\Select::make('invoice_id')
                    ->relationship('invoice', 'invoice_no')
                    ->searchable()
                    ->required()
                    ->label('Faktur'),
                Forms\Components\TextInput::make('return_no')
                    ->required()
                    ->maxLength(255)
                    ->label('No. Retur'),
                Forms\Components\DatePicker::make('return_date')
                    ->required()
                    ->label('Tgl Retur'),
                Forms\Components\Select::make('warehouse_id')
                    ->relationship('warehouse', 'name')
                    ->label('Gudang'),
                Forms\Components\Select::make('refund_type')
                    ->required()
                    ->options([
                        'refund' => 'Refund',
                        'credit_note' => 'Credit Note',
                    ])
                    ->label('Tipe Refund'),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'draft' => 'Draft',
                        'processed' => 'Diproses',
                    ])
                    ->label('Status'),
                Forms\Components\TextInput::make('subtotal')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->label('Subtotal'),
                Forms\Components\DateTimePicker::make('posted_at')
                    ->label('Tgl Posting'),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull()
                    ->label('Catatan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('return_no')
                    ->label('No. Retur')
                    ->searchable(),
                Tables\Columns\TextColumn::make('invoice.invoice_no')
                    ->label('Faktur')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('return_date')
                    ->label('Tgl Retur')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('warehouse.name')
                    ->label('Gudang'),
                Tables\Columns\TextColumn::make('refund_type')
                    ->label('Tipe Refund')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'refund' => 'warning',
                        'credit_note' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'processed' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            'index' => Pages\ListSalesReturns::route('/'),
            'create' => Pages\CreateSalesReturn::route('/create'),
            'edit' => Pages\EditSalesReturn::route('/{record}/edit'),
        ];
    }
}
