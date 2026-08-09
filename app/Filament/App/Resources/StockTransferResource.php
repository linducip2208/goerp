<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\StockTransferResource\Pages;
use App\Filament\App\Resources\StockTransferResource\RelationManagers\ItemsRelationManager;
use App\Models\StockTransfer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StockTransferResource extends Resource
{
    protected static ?string $model = StockTransfer::class;

    protected static ?string $navigationGroup = '📦 Produk & Inventori';
    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';
    protected static ?int $navigationSort = 19;
    protected static ?string $modelLabel = 'Transfer Gudang';
    protected static ?string $pluralModelLabel = 'Transfer Gudang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Hidden::make('company_id'),
                Forms\Components\Select::make('from_warehouse_id')
                    ->relationship('fromWarehouse', 'name')
                    ->required()
                    ->label('Gudang Asal'),
                Forms\Components\Select::make('to_warehouse_id')
                    ->relationship('toWarehouse', 'name')
                    ->required()
                    ->label('Gudang Tujuan'),
                Forms\Components\TextInput::make('transfer_no')
                    ->required()
                    ->maxLength(255)
                    ->label('No. Transfer'),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'draft' => 'Draft',
                        'approved' => 'Disetujui',
                        'in_transit' => 'Dalam Perjalanan',
                        'received' => 'Diterima',
                        'cancelled' => 'Dibatalkan',
                    ])
                    ->label('Status'),
                Forms\Components\Select::make('approved_by')
                    ->relationship('approvedBy', 'name')
                    ->searchable()
                    ->label('Disetujui Oleh'),
                Forms\Components\DatePicker::make('request_date')
                    ->label('Tgl Pengajuan'),
                Forms\Components\DatePicker::make('receive_date')
                    ->label('Tgl Diterima'),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull()
                    ->label('Catatan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transfer_no')
                    ->label('No. Transfer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fromWarehouse.name')
                    ->label('Gudang Asal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('toWarehouse.name')
                    ->label('Gudang Tujuan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('request_date')
                    ->label('Tgl Pengajuan')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'approved' => 'warning',
                        'in_transit' => 'info',
                        'received' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('approvedBy.name')
                    ->label('Disetujui Oleh'),
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
            ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStockTransfers::route('/'),
            'create' => Pages\CreateStockTransfer::route('/create'),
            'edit' => Pages\EditStockTransfer::route('/{record}/edit'),
        ];
    }
}
