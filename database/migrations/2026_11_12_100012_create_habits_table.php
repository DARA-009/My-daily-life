<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<'SQL'
CREATE TABLE habits (
    id               bigint GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    user_id          bigint NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    name             varchar(150) NOT NULL,
    description      text,
    frequency        varchar(10) NOT NULL,
    target_per_week  smallint NOT NULL,
    start_date       date NOT NULL,
    archived_at      timestamptz,
    created_at       timestamptz NOT NULL DEFAULT now(),
    updated_at       timestamptz NOT NULL DEFAULT now(),
    deleted_at       timestamptz,
    CONSTRAINT habits_frequency_check CHECK (frequency IN ('daily', 'weekly')),
    CONSTRAINT habits_target_check CHECK (target_per_week BETWEEN 1 AND 7),
    CONSTRAINT habits_daily_target_check CHECK (frequency <> 'daily' OR target_per_week = 7)
);
CREATE INDEX habits_user_idx ON habits (user_id) WHERE deleted_at IS NULL;
SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP TABLE IF EXISTS habits CASCADE');
    }
};
