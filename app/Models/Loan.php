<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Loan extends Model
{
    protected $fillable = [
        'user_id',
        'account_id',
        'type',
        'person_name',
        'person_contact',
        'amount',
        'remaining_amount',
        'description',
        'loan_date',
        'due_date',
        'status',
        'interest_rate'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'loan_date' => 'date',
        'due_date' => 'date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function isOverdue(): bool
    {
        return $this->due_date && $this->due_date->isPast() && $this->status === 'active';
    }

    public function getPaidAmountAttribute(): float
    {
        return $this->amount - $this->remaining_amount;
    }

    public function getProgressPercentageAttribute(): float
    {
        return $this->amount > 0 ? ($this->paid_amount / $this->amount) * 100 : 0;
    }
}
