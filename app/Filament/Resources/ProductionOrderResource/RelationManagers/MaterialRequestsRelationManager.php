<?php

namespace App\Filament\Resources\ProductionOrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class MaterialRequestsRelationManager extends RelationManager
{
    protected static string $relationship = 'materialRequests';

    protected static ?string $title = 'Permintaan Material';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('request_no')
                    ->required()
                    ->maxLength(255)
                    ->label('No. Permintaan'),
                Forms\Components\DatePicker::make('request_date')
                    ->required()
                    ->default(now())
                    ->label('Tgl Permintaan'),
                Forms\Components\Select::make('warehouse_id')
                    ->relationship('warehouse', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Gudang'),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'draft' => 'Draft',
                        'requested' => 'Diminta',
                        'issued' => 'Dikeluarkan',
                    ])
                    ->default('draft')
                    ->label('Status'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('request_no')
            ->columns([
                Tables\Columns\TextColumn::make('request_no')
                    ->label('No. Permintaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('request_date')
                    ->label('Tgl Permintaan')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('warehouse.name')
                    ->label('Gudang'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'requested' => 'warning',
                        'issued' => 'success',
                        default => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Permintaan'),
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
