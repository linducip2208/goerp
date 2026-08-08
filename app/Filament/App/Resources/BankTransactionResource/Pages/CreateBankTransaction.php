<?php

namespace App\Filament\App\Resources\BankTransactionResource\Pages;

use App\Filament\App\Resources\BankTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBankTransaction extends CreateRecord
{
    protected static string $resource = BankTransactionResource::class;
}
