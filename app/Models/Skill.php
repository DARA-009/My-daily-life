<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Skill extends Model
{
    use SoftDeletes;

    protected $fillable = ['category_id', 'name', 'description', 'current_level', 'target_level'];

    protected $casts = ['current_level' => 'integer', 'target_level' => 'integer'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(SkillActivity::class);
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where($this->getTable() . '.user_id', $userId);
    }
}
