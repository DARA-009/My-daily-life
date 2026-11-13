<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<'SQL'
CREATE TABLE notes (
    id           bigint GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    user_id      bigint NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    category_id  bigint REFERENCES categories(id) ON DELETE SET NULL,
    title        varchar(255) NOT NULL,
    body         text NOT NULL DEFAULT '',
    is_pinned    boolean NOT NULL DEFAULT false,
    created_at   timestamptz NOT NULL DEFAULT now(),
    updated_at   timestamptz NOT NULL DEFAULT now(),
    deleted_at   timestamptz
);
CREATE INDEX notes_user_pinned_idx ON notes (user_id, is_pinned, updated_at DESC);
CREATE INDEX notes_title_trgm_idx ON notes USING gin (title gin_trgm_ops);
CREATE INDEX notes_body_trgm_idx ON notes USING gin (body gin_trgm_ops);
SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP TABLE IF EXISTS notes CASCADE');
    }
};
