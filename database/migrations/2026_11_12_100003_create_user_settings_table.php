<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<'SQL'
CREATE TABLE user_settings (
    id                bigint GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    user_id           bigint NOT NULL UNIQUE REFERENCES users(id) ON DELETE CASCADE,
    locale            varchar(2) NOT NULL DEFAULT 'km',
    default_currency  char(3) NOT NULL DEFAULT 'USD',
    timezone          varchar(64) NOT NULL DEFAULT 'Asia/Phnom Penh',
    notify_in_app     boolean NOT NULL DEFAULT true,
    notify_email      boolean NOT NULL DEFAULT false,
    created_at        timestamptz NOT NULL DEFAULT now(),
    updated_at        timestamptz NOT NULL DEFAULT now(),
    CONSTRAINT user_settings_locale_check CHECK (locale IN ('km', 'en')),
    CONSTRAINT user_settings_currency_check CHECK (default_currency IN ('USD', 'KHR'))
);
SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP TABLE IF EXISTS user_settings CASCADE');
    }
};
