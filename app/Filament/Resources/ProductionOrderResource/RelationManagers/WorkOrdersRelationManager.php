<?php

namespace App\Filament\Resources\ProductionOrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class WorkOrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'workOrders';

    protected static ?string $title = 'Work Order';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
                    ->label('Catatan'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('work_order_no')
            ->columns([
                Tables\Columns\TextColumn::make('work_order_no')
                    ->label('No. WO')
                    ->searchable(),
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
                Tables\Columns\TextColumn::make('target_qty')
                    ->label('Target Qty')
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),
                Tables\Columns\TextColumn::make('actual_qty')
                    ->label('Qty Aktual')
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),
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
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Work Order'),
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
