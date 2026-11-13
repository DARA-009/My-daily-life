<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSetting extends Model
{
    protected $fillable = ['locale', 'default_currency', 'timezone', 'notify_in_app', 'notify_email'];

    protected $casts = ['notify_in_app' => 'boolean', 'notify_email' => 'boolean'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
