<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\SalesLeadResource\Pages;
use App\Filament\App\Resources\SalesLeadResource\RelationManagers;
use App\Models\SalesLead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SalesLeadResource extends Resource
{
    protected static ?string $model = SalesLead::class;

    protected static ?string $navigationGroup = '💰 CRM';
    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?int $navigationSort = 18;
    protected static ?string $modelLabel = 'Prospek';
    protected static ?string $pluralModelLabel = 'Prospek';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListSalesLeads::route('/'),
            'create' => Pages\CreateSalesLead::route('/create'),
            'edit' => Pages\EditSalesLead::route('/{record}/edit'),
        ];
    }
}
