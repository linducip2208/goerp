<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\WorkOrderResource\Pages;
use App\Models\WorkOrder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WorkOrderResource extends Resource
{
    protected static ?string $model = WorkOrder::class;

    protected static ?string $navigationGroup = '🏭 Produksi';
    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    protected static ?int $navigationSort = 152;
    protected static ?string $modelLabel = 'Work Order';
    protected static ?string $pluralModelLabel = 'Work Order';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('production_order_id')
                    ->relationship('productionOrder', 'order_no')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Production Order'),
                Forms\Components\TextInput::make('work_order_no')
                    ->required()
                    ->maxLength(255)
                    ->label('No. Work Order'),
                Forms\Components\Select::make('stage')
                    ->required()
                    ->options([
                        'cutting' => 'Cutting',
                        'sewing' => 'Sewing',
                        'finishing' => 'Finishing',
                        'qc' => 'QC',
                        'packing' => 'Packing',
                    ])
                    ->label('Tahap'),
                Forms\Components\TextInput::make('team')
                    ->maxLength(255)
                    ->label('Tim'),
                Forms\Components\TextInput::make('operator')
                    ->maxLength(255)
                    ->label('Operator'),
                Forms\Components\DatePicker::make('start_date')
                    ->required()
                    ->label('Tgl Mulai'),
                Forms\Components\DatePicker::make('end_date')
                    ->required()
                    ->label('Tgl Selesai'),
                Forms\Components\TextInput::make('target_qty')
                    ->required()
                    ->numeric()
                    ->label('Target Qty'),
                Forms\Components\TextInput::make('actual_qty')
                    ->numeric()
                    ->default(0.00)
                    ->label('Qty Aktual'),
                Forms\Components\TextInput::make('reject_qty')
                    ->numeric()
                    ->default(0.00)
                    ->label('Qty Reject'),
                Forms\Components\TextInput::make('rework_qty')
                    ->numeric()
                    ->default(0.00)
                    ->label('Qty Rework'),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                    ])
                    ->default('pending')
                    ->label('Status'),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull()
                    ->label('Catatan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('work_order_no')
                    ->label('No. WO')
                    ->searchable(),
                Tables\Columns\TextColumn::make('productionOrder.order_no')
                    ->label('No. PO')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('stage')
                    ->label('Tahap')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'cutting' => 'danger',
                        'sewing' => 'warning',
                        'finishing' => 'info',
                        'qc' => 'success',
                        'packing' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('team')
                    ->label('Tim')
                    ->searchable(),
                Tables\Columns\TextColumn::make('operator')
                    ->label('Operator')
                    ->searchable(),
                Tables\Columns\TextColumn::make('target_qty')
                    ->label('Target Qty')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('actual_qty')
                    ->label('Qty Aktual')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reject_qty')
                    ->label('Qty Reject')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('rework_qty')
                    ->label('Qty Rework')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'gray',
                        'in_progress' => 'warning',
                        'completed' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Tgl Mulai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Tgl Selesai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
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
            'index' => Pages\ListWorkOrders::route('/'),
            'create' => Pages\CreateWorkOrder::route('/create'),
            'edit' => Pages\EditWorkOrder::route('/{record}/edit'),
        ];
    }
}
