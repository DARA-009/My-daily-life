<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<'SQL'
CREATE TABLE notifications (
    id               uuid PRIMARY KEY,
    type             varchar(255) NOT NULL,
    notifiable_type  varchar(255) NOT NULL,
    notifiable_id    bigint NOT NULL,
    data             jsonb NOT NULL,
    read_at          timestamptz,
    created_at       timestamptz,
    updated_at       timestamptz
);
CREATE INDEX notifications_notifiable_idx ON notifications (notifiable_type, notifiable_id);
SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP TABLE IF EXISTS notifications CASCADE');
    }
};
