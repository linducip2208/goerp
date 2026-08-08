<?php

namespace App\Filament\App\Resources\RecurringJournalResource\Pages;

use App\Filament\App\Resources\RecurringJournalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRecurringJournal extends EditRecord
{
    protected static string $resource = RecurringJournalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
