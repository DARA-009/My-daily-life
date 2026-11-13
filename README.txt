My Daily Life - Package 01: database layer (Phase 5)

Contents (copy into the Laravel project root, keeping the folders):
  database/migrations/  18 migrations (pg_trgm, users email index, 16 tables)
  database/seeders/     DefaultCategorySeeder
  app/Models/           15 Eloquent models
  app/Models/Concerns/  HasDailyLifeRelations (add this trait to your existing User model)
  lang/en, lang/km      category names
  docs/                 01_create_database.sql

The migrations run the same SQL that was verified on PostgreSQL 16, and the resulting
structure was compared with the verified schema script (identical).
NOT yet tested on a real Laravel 13 install: the Eloquent models and the seeder (syntax-checked only).
