<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudySession extends Model
{
    use SoftDeletes;

    public const STATUSES = ['planned', 'completed', 'skipped'];

    // duration_minutes is a generated column in PostgreSQL, so it is intentionally not fillable.
    protected $fillable = ['subject_id', 'session_date', 'start_time', 'end_time', 'status', 'notes'];

    protected $casts = ['session_date' => 'date', 'duration_minutes' => 'integer'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where($this->getTable() . '.user_id', $userId);
    }
}
