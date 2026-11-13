<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<'SQL'
CREATE TABLE skills (
    id             bigint GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    user_id        bigint NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    category_id    bigint REFERENCES categories(id) ON DELETE SET NULL,
    name           varchar(150) NOT NULL,
    description    text,
    current_level  smallint NOT NULL DEFAULT 1,
    target_level   smallint NOT NULL DEFAULT 5,
    created_at     timestamptz NOT NULL DEFAULT now(),
    updated_at     timestamptz NOT NULL DEFAULT now(),
    deleted_at     timestamptz,
    CONSTRAINT skills_current_level_check CHECK (current_level BETWEEN 1 AND 5),
    CONSTRAINT skills_target_level_check CHECK (target_level BETWEEN 1 AND 5)
);
CREATE UNIQUE INDEX skills_user_name_unique
    ON skills (user_id, lower(name)) WHERE deleted_at IS NULL;
SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP TABLE IF EXISTS skills CASCADE');
    }
};
