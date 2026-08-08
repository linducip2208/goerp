<?php

namespace App\Models;

use App\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecurringJournal extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'company_id',
        'name',
        'frequency',
        'next_date',
        'account_debit_id',
        'account_credit_id',
        'amount',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'next_date' => 'date',
            'amount' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function accountDebit(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_debit_id');
    }

    public function accountCredit(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_credit_id');
    }
}
