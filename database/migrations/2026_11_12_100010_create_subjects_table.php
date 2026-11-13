<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<'SQL'
CREATE TABLE subjects (
    id               bigint GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    user_id          bigint NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    name             varchar(150) NOT NULL,
    description      text,
    learning_target  text,
    target_hours     numeric(6,1),
    created_at       timestamptz NOT NULL DEFAULT now(),
    updated_at       timestamptz NOT NULL DEFAULT now(),
    deleted_at       timestamptz,
    CONSTRAINT subjects_target_hours_check CHECK (target_hours IS NULL OR target_hours >= 0)
);
CREATE UNIQUE INDEX subjects_user_name_unique
    ON subjects (user_id, lower(name)) WHERE deleted_at IS NULL;
SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP TABLE IF EXISTS subjects CASCADE');
    }
};
