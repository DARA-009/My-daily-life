<?php

namespace App\Models\Concerns;

use App\Models\Activity;
use App\Models\Category;
use App\Models\Goal;
use App\Models\Habit;
use App\Models\Note;
use App\Models\Profile;
use App\Models\Skill;
use App\Models\StudySession;
use App\Models\Subject;
use App\Models\Task;
use App\Models\Transaction;
use App\Models\UserSetting;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Add to App\Models\User:  use HasDailyLifeRelations;
 */
trait HasDailyLifeRelations
{
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function settings(): HasOne
    {
        return $this->hasOne(UserSetting::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class);
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }

    public function studySessions(): HasMany
    {
        return $this->hasMany(StudySession::class);
    }

    public function habits(): HasMany
    {
        return $this->hasMany(Habit::class);
    }

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}
