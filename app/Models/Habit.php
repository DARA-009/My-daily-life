<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Habit extends Model
{
    use SoftDeletes;

    public const FREQUENCIES = ['daily', 'weekly'];

    protected $fillable = ['name', 'description', 'frequency', 'target_per_week', 'start_date', 'archived_at'];

    protected $casts = [
        'start_date' => 'date',
        'archived_at' => 'datetime',
        'target_per_week' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(HabitLog::class);
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where($this->getTable() . '.user_id', $userId);
    }
}
