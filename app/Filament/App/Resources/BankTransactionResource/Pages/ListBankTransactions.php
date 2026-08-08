<?php

namespace App\Filament\App\Resources\BankTransactionResource\Pages;

use App\Filament\App\Resources\BankTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBankTransactions extends ListRecords
{
    protected static string $resource = BankTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
