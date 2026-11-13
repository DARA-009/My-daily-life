<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    public const KINDS = ['personal', 'work', 'study'];
    public const PRIORITIES = ['low', 'medium', 'high'];
    public const STATUSES = ['pending', 'in_progress', 'completed'];

    protected $fillable = [
        'category_id', 'kind', 'title', 'description', 'priority',
        'due_date', 'status', 'progress_percent', 'completed_at',
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
        'progress_percent' => 'integer',
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

    /** Overdue is calculated, never stored. */
    public function scopeOverdue($query)
    {
        return $query->where('status', '!=', 'completed')
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', today());
    }
}
