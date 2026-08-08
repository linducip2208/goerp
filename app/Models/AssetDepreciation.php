<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetDepreciation extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'period',
        'depreciation_amount',
        'accumulated_amount',
        'book_value',
        'journal_entry_id',
        'run_date',
    ];

    protected function casts(): array
    {
        return [
            'depreciation_amount' => 'decimal:2',
            'accumulated_amount' => 'decimal:2',
            'book_value' => 'decimal:2',
            'run_date' => 'date',
        ];
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(FixedAsset::class, 'asset_id');
    }

    public function journalEntry(): BelongsTo
    {
        return $this->belongsTo(JournalEntry::class);
    }
}
