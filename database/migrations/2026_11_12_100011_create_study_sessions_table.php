<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<'SQL'
CREATE TABLE study_sessions (
    id                bigint GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    user_id           bigint NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    subject_id        bigint NOT NULL REFERENCES subjects(id) ON DELETE RESTRICT,
    session_date      date NOT NULL,
    start_time        time NOT NULL,
    end_time          time NOT NULL,
    duration_minutes  integer GENERATED ALWAYS AS
                      ((EXTRACT(EPOCH FROM (end_time - start_time)) / 60)::integer) STORED,
    status            varchar(20) NOT NULL DEFAULT 'planned',
    notes             text,
    created_at        timestamptz NOT NULL DEFAULT now(),
    updated_at        timestamptz NOT NULL DEFAULT now(),
    deleted_at        timestamptz,
    CONSTRAINT study_sessions_time_check CHECK (end_time > start_time),
    CONSTRAINT study_sessions_status_check CHECK (status IN ('planned', 'completed', 'skipped'))
);
CREATE INDEX study_sessions_user_date_idx ON study_sessions (user_id, session_date);
CREATE INDEX study_sessions_subject_date_idx ON study_sessions (subject_id, session_date);
SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP TABLE IF EXISTS study_sessions CASCADE');
    }
};
