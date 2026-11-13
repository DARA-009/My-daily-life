<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'name', 'description', 'learning_target', 'target_hours'];

    protected $casts = ['target_hours' => 'decimal:1'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function studySessions(): HasMany
    {
        return $this->hasMany(StudySession::class);
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where($this->getTable() . '.user_id', $userId);
    }
}
