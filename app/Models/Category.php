<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use SoftDeletes;

    public const TYPES = ['activity', 'task', 'income', 'expense', 'note', 'skill'];

    protected $fillable = ['type', 'name', 'system_key', 'color'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where($this->getTable() . '.user_id', $userId);
    }

    /**
     * Default categories carry a system_key and are translated through the lang files (categories.php).
     * Categories created by the user keep their own name and are never translated.
     */
    public function getDisplayNameAttribute(): string
    {
        if ($this->system_key === null) {
            return $this->name;
        }

        $key = 'categories.' . $this->system_key;
        $translated = __($key);

        return $translated === $key ? $this->name : $translated;
    }
}
