<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<'SQL'
CREATE TABLE goals (
    id                bigint GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    user_id           bigint NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    title             varchar(255) NOT NULL,
    description       text,
    target_year       smallint NOT NULL,
    target_month      smallint NOT NULL,
    start_date        date NOT NULL,
    deadline          date NOT NULL,
    priority          varchar(10) NOT NULL DEFAULT 'medium',
    progress_percent  smallint NOT NULL DEFAULT 0,
    status            varchar(20) NOT NULL DEFAULT 'pending',
    completed_at      timestamptz,
    created_at        timestamptz NOT NULL DEFAULT now(),
    updated_at        timestamptz NOT NULL DEFAULT now(),
    deleted_at        timestamptz,
    CONSTRAINT goals_month_check CHECK (target_month BETWEEN 1 AND 12),
    CONSTRAINT goals_dates_check CHECK (deadline >= start_date),
    CONSTRAINT goals_priority_check CHECK (priority IN ('low', 'medium', 'high')),
    CONSTRAINT goals_progress_check CHECK (progress_percent BETWEEN 0 AND 100),
    CONSTRAINT goals_status_check CHECK (status IN ('pending', 'in_progress', 'completed', 'cancelled'))
);
CREATE INDEX goals_user_period_idx ON goals (user_id, target_year, target_month, status);
SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP TABLE IF EXISTS goals CASCADE');
    }
};
