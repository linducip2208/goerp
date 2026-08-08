<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'company_id',
        'bank_account_id',
        'transaction_type',
        'transaction_date',
        'contact_id',
        'account_id',
        'amount',
        'memo',
        'reference',
        'reconciled',
        'reconciled_at',
        'attachment',
    ];

    protected function casts(): array
    {
        return [
            'transaction_date' => 'date',
            'reconciled_at' => 'datetime',
            'reconciled' => 'boolean',
            'amount' => 'decimal:2',
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

    public function bankAccount(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
