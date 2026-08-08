<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\WorkflowRuleResource\Pages;
use App\Models\WorkflowRule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WorkflowRuleResource extends Resource
{
    protected static ?string $model = WorkflowRule::class;

    protected static ?string $navigationGroup = '🔄 Workflow';
    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';
    protected static ?int $navigationSort = 95;
    protected static ?string $modelLabel = 'Aturan Workflow';
    protected static ?string $pluralModelLabel = 'Aturan Workflow';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama'),
                Forms\Components\TextInput::make('module')
                    ->required()
                    ->maxLength(255)
                    ->label('Modul'),
                Forms\Components\TextInput::make('trigger_event')
                    ->required()
                    ->maxLength(255)
                    ->label('Trigger Event'),
                Forms\Components\TextInput::make('condition_field')
                    ->maxLength(255)
                    ->label('Condition Field'),
                Forms\Components\TextInput::make('condition_operator')
                    ->maxLength(255)
                    ->label('Condition Operator'),
                Forms\Components\TextInput::make('condition_value')
                    ->maxLength(255)
                    ->label('Condition Value'),
                Forms\Components\Select::make('action_type')
                    ->required()
                    ->options([
                        'notify' => 'Notifikasi',
                        'approve' => 'Persetujuan',
                        'auto_post' => 'Auto Post',
                        'reject' => 'Tolak',
                    ])
                    ->label('Tipe Aksi'),
                Forms\Components\Textarea::make('action_params')
                    ->columnSpanFull()
                    ->label('Action Params (JSON)'),
                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->default(true)
                    ->label('Aktif'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('module')
                    ->label('Modul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('trigger_event')
                    ->label('Trigger')
                    ->searchable(),
                Tables\Columns\TextColumn::make('action_type')
                    ->label('Aksi')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'notify' => 'info',
                        'approve' => 'warning',
                        'auto_post' => 'success',
                        'reject' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
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
            'index' => Pages\ListWorkflowRules::route('/'),
            'create' => Pages\CreateWorkflowRule::route('/create'),
            'edit' => Pages\EditWorkflowRule::route('/{record}/edit'),
        ];
    }
}
