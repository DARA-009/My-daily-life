<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<'SQL'
CREATE TABLE activities (
    id             bigint GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    user_id        bigint NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    category_id    bigint REFERENCES categories(id) ON DELETE SET NULL,
    title          varchar(255) NOT NULL,
    description    text,
    activity_date  date NOT NULL,
    start_time     time NOT NULL,
    end_time       time NOT NULL,
    status         varchar(20) NOT NULL DEFAULT 'planned',
    created_at     timestamptz NOT NULL DEFAULT now(),
    updated_at     timestamptz NOT NULL DEFAULT now(),
    deleted_at     timestamptz,
    CONSTRAINT activities_time_check CHECK (end_time > start_time),
    CONSTRAINT activities_status_check CHECK (status IN ('planned', 'in_progress', 'done', 'skipped'))
);
CREATE INDEX activities_user_date_idx ON activities (user_id, activity_date, start_time);
SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP TABLE IF EXISTS activities CASCADE');
    }
};
