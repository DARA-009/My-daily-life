<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    public const TYPES = ['income', 'expense'];
    public const CURRENCIES = ['USD', 'KHR'];
    public const PAYMENT_METHODS = ['cash', 'bank', 'card', 'mobile_wallet', 'other'];

    protected $fillable = [
        'category_id', 'type', 'amount', 'currency',
        'transaction_date', 'payment_method', 'description', 'notes',
    ];

    // Money stays a decimal string. Never cast it to float, and never add USD and KHR together.
    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where($this->getTable() . '.user_id', $userId);
    }

    public function scopeInCurrency($query, string $currency)
    {
        return $query->where('currency', $currency);
    }
}
