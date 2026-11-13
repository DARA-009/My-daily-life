<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<'SQL'
CREATE TABLE habit_logs (
    id          bigint GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    habit_id    bigint NOT NULL REFERENCES habits(id) ON DELETE CASCADE,
    log_date    date NOT NULL,
    note        varchar(255),
    created_at  timestamptz NOT NULL DEFAULT now(),
    CONSTRAINT habit_logs_unique UNIQUE (habit_id, log_date)
);
SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP TABLE IF EXISTS habit_logs CASCADE');
    }
};
