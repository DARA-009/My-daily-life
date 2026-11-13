<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoalProgressLog extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = ['progress_percent', 'note', 'logged_on'];

    protected $casts = ['logged_on' => 'date', 'progress_percent' => 'integer'];

    public function goal(): BelongsTo
    {
        return $this->belongsTo(Goal::class);
    }
}
