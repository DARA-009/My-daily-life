<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<'SQL'
CREATE TABLE tasks (
    id                bigint GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    user_id           bigint NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    category_id       bigint REFERENCES categories(id) ON DELETE SET NULL,
    kind              varchar(20) NOT NULL DEFAULT 'personal',
    title             varchar(255) NOT NULL,
    description       text,
    priority          varchar(10) NOT NULL DEFAULT 'medium',
    due_date          date,
    status            varchar(20) NOT NULL DEFAULT 'pending',
    progress_percent  smallint NOT NULL DEFAULT 0,
    completed_at      timestamptz,
    created_at        timestamptz NOT NULL DEFAULT now(),
    updated_at        timestamptz NOT NULL DEFAULT now(),
    deleted_at        timestamptz,
    CONSTRAINT tasks_kind_check CHECK (kind IN ('personal', 'work', 'study')),
    CONSTRAINT tasks_priority_check CHECK (priority IN ('low', 'medium', 'high')),
    CONSTRAINT tasks_status_check CHECK (status IN ('pending', 'in_progress', 'completed')),
    CONSTRAINT tasks_progress_check CHECK (progress_percent BETWEEN 0 AND 100),
    CONSTRAINT tasks_completed_at_check CHECK ((status = 'completed') = (completed_at IS NOT NULL))
);
CREATE INDEX tasks_user_status_due_idx ON tasks (user_id, status, due_date);
CREATE INDEX tasks_user_kind_idx ON tasks (user_id, kind);
SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP TABLE IF EXISTS tasks CASCADE');
    }
};
