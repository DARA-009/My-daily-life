<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<'SQL'
CREATE TABLE skill_activities (
    id                bigint GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    skill_id          bigint NOT NULL REFERENCES skills(id) ON DELETE CASCADE,
    activity_date     date NOT NULL,
    title             varchar(255) NOT NULL,
    description       text,
    duration_minutes  integer,
    level_after       smallint,
    created_at        timestamptz NOT NULL DEFAULT now(),
    updated_at        timestamptz NOT NULL DEFAULT now(),
    CONSTRAINT skill_activities_duration_check CHECK (duration_minutes IS NULL OR duration_minutes > 0),
    CONSTRAINT skill_activities_level_check CHECK (level_after IS NULL OR level_after BETWEEN 1 AND 5)
);
CREATE INDEX skill_activities_skill_date_idx ON skill_activities (skill_id, activity_date);
SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP TABLE IF EXISTS skill_activities CASCADE');
    }
};
