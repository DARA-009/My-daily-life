<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<'SQL'
CREATE TABLE goal_progress_logs (
    id                bigint GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    goal_id           bigint NOT NULL REFERENCES goals(id) ON DELETE CASCADE,
    progress_percent  smallint NOT NULL,
    note              text,
    logged_on         date NOT NULL,
    created_at        timestamptz NOT NULL DEFAULT now(),
    CONSTRAINT goal_logs_progress_check CHECK (progress_percent BETWEEN 0 AND 100)
);
CREATE INDEX goal_logs_goal_date_idx ON goal_progress_logs (goal_id, logged_on);
SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP TABLE IF EXISTS goal_progress_logs CASCADE');
    }
};
