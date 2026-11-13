<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<'SQL'
CREATE TABLE transactions (
    id                bigint GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    user_id           bigint NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    category_id       bigint NOT NULL REFERENCES categories(id) ON DELETE RESTRICT,
    type              varchar(10) NOT NULL,
    amount            numeric(15,2) NOT NULL,
    currency          char(3) NOT NULL,
    transaction_date  date NOT NULL,
    payment_method    varchar(20) NOT NULL,
    description       varchar(255) NOT NULL,
    notes             text,
    created_at        timestamptz NOT NULL DEFAULT now(),
    updated_at        timestamptz NOT NULL DEFAULT now(),
    deleted_at        timestamptz,
    CONSTRAINT transactions_type_check CHECK (type IN ('income', 'expense')),
    CONSTRAINT transactions_amount_check CHECK (amount > 0),
    CONSTRAINT transactions_currency_check CHECK (currency IN ('USD', 'KHR')),
    CONSTRAINT transactions_payment_check CHECK (payment_method IN ('cash', 'bank', 'card', 'mobile_wallet', 'other'))
);
CREATE INDEX transactions_user_date_idx ON transactions (user_id, transaction_date);
CREATE INDEX transactions_report_idx ON transactions (user_id, type, currency, transaction_date);
CREATE INDEX transactions_category_idx ON transactions (category_id);
SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP TABLE IF EXISTS transactions CASCADE');
    }
};
