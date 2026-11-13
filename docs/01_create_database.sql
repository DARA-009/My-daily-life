-- My Daily Life: create the PostgreSQL role and database.
-- STEP A: connect as the postgres superuser to the database "postgres" and run the first three statements.
-- Replace the password. Do not share it and do not commit it to Git.

CREATE ROLE mdl_user WITH LOGIN PASSWORD 'CHANGE_ME_STRONG_PASSWORD';
CREATE DATABASE my_daily_life OWNER mdl_user ENCODING 'UTF8';
ALTER DATABASE my_daily_life SET timezone TO 'UTC';

-- If CREATE DATABASE complains about the encoding/locale on Windows, use this instead of line 2:
-- CREATE DATABASE my_daily_life OWNER mdl_user ENCODING 'UTF8' LOCALE 'C' TEMPLATE template0;

-- STEP B: connect to the database "my_daily_life" (still as postgres) and run:
CREATE EXTENSION IF NOT EXISTS pg_trgm;

-- STEP C (check): both columns must say UTF8 / UTC.
SELECT pg_encoding_to_char(encoding) AS encoding FROM pg_database WHERE datname = 'my_daily_life';
SHOW timezone;
