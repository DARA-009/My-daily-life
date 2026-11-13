<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SkillActivity extends Model
{
    protected $fillable = ['activity_date', 'title', 'description', 'duration_minutes', 'level_after'];

    protected $casts = ['activity_date' => 'date'];

    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }
}
