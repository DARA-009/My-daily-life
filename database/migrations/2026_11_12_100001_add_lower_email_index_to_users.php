<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<'SQL'
CREATE UNIQUE INDEX IF NOT EXISTS users_email_lower_unique ON users (lower(email));
SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP INDEX IF EXISTS users_email_lower_unique');
    }
};
