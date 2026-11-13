<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<'SQL'
CREATE TABLE profiles (
    id             bigint GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    user_id        bigint NOT NULL UNIQUE REFERENCES users(id) ON DELETE CASCADE,
    full_name      varchar(255) NOT NULL,
    date_of_birth  date,
    gender         varchar(20),
    phone          varchar(30),
    address        text,
    bio            text,
    photo_path     varchar(255),
    created_at     timestamptz NOT NULL DEFAULT now(),
    updated_at     timestamptz NOT NULL DEFAULT now(),
    CONSTRAINT profiles_gender_check CHECK (gender IS NULL OR gender IN ('male', 'female', 'other'))
);
SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP TABLE IF EXISTS profiles CASCADE');
    }
};
