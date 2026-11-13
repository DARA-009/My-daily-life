<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<'SQL'
CREATE TABLE categories (
    id          bigint GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    user_id     bigint NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    type        varchar(20) NOT NULL,
    name        varchar(100) NOT NULL,
    system_key  varchar(50),
    color       varchar(7),
    created_at  timestamptz NOT NULL DEFAULT now(),
    updated_at  timestamptz NOT NULL DEFAULT now(),
    deleted_at  timestamptz,
    CONSTRAINT categories_type_check CHECK (type IN ('activity', 'task', 'income', 'expense', 'note', 'skill')),
    CONSTRAINT categories_color_check CHECK (color IS NULL OR color ~ '^#[0-9A-Fa-f]{6}$')
);
CREATE UNIQUE INDEX categories_user_type_name_unique
    ON categories (user_id, type, lower(name)) WHERE deleted_at IS NULL;
SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP TABLE IF EXISTS categories CASCADE');
    }
};
