<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HabitLog extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = ['log_date', 'note'];

    protected $casts = ['log_date' => 'date'];

    public function habit(): BelongsTo
    {
        return $this->belongsTo(Habit::class);
    }
}
