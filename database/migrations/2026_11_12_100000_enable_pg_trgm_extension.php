<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<'SQL'
CREATE EXTENSION IF NOT EXISTS pg_trgm;
SQL);
    }

    public function down(): void
    {
        DB::unprepared('SELECT 1');
    }
};
