# ជីវិតប្រចាំថ្ងៃរបស់ខ្ញុំ — My Daily Life

> **ប្រព័ន្ធគ្រប់គ្រងជីវិត ការងារ និងផលិតភាពផ្ទាល់ខ្លួនកម្រិតវិជ្ជាជីវៈ (Professional Full-Stack Personal Productivity & Life Management System)**  
> បង្កើតឡើងដោយប្រើប្រាស់ **Laravel 13**, **PHP 8.5**, **PostgreSQL 18.1**, **Tailwind CSS v4**, **Alpine.js**, និង **Chart.js**។

---

## 🌟 តារាងមាតិកា / Table of Contents
- [១. ទិដ្ឋភាពទូទៅនៃគម្រោង (Project Overview)](#1-ទិដ្ឋភាពទូទៅនៃគម្រោង-project-overview)
- [២. ម៉ូឌុលស្នូលទាំង ១២ (The 12 Core Modules)](#2-ម៉ូឌុលស្នូលទាំង-១២-the-12-core-modules)
- [៣. បច្ចេកវិទ្យា & ស្ថាបត្យកម្ម (Tech Stack & Architecture)](#3-បច្ចេកវិទ្យា--ស្ថាបត្យកម្ម-tech-stack--architecture)
- [៤. ការដំឡើង និងដំណើរការក្នុងម៉ាស៊ីនផ្ទាល់ (Local Setup Guide)](#4-ការដំឡើង-និងដំណើរការក្នុងម៉ាស៊ីនផ្ទាល់-local-setup-guide)
- [៥. ស្ថាបត្យកម្មមូលដ្ឋានទិន្នន័យ (Database Architecture & Migrations)](#5-ស្ថាបត្យកម្មមូលដ្ឋានទិន្នន័យ-database-architecture--migrations)
- [៦. ការធ្វើតេស្តស្វ័យប្រវត្ត (Automated Testing & QA)](#6-ការធ្វើតេស្តស្វ័យប្រវត្ត-automated-testing--qa)
- [៧. ការដាក់ឱ្យប្រើប្រាស់ក្នុង Production (Deployment & Runbook)](#7-ការដាក់ឱ្យប្រើប្រាស់ក្នុង-production-deployment--runbook)
- [៨. ដំណោះស្រាយបញ្ហាទូទៅ (Troubleshooting Guide)](#8-ដំណោះស្រាយបញ្ហាទូទៅ-troubleshooting-guide)

---

## 1. ទិដ្ឋភាពទូទៅនៃគម្រោង (Project Overview)

**ជីវិតប្រចាំថ្ងៃរបស់ខ្ញុំ (My Daily Life)** គឺជាគេហទំព័រកម្មវិធីពេញលេញ (Full-stack Web Application) ដែលត្រូវបានរចនាឡើងយ៉ាងយកចិត្តទុកដាក់ខ្ពស់បំផុត សម្រាប់ជួយបុគ្គលម្នាក់ៗក្នុងការគ្រប់គ្រងពេលវេលា ហិរញ្ញវត្ថុ ផលិតភាពការងារ ការសិក្សា និងទម្លាប់ប្រចាំថ្ងៃ។

### ចំណុចលេចធ្លោ (Key Features):
- **Bilingual Interface (ទ្វេភាសា):** គាំទ្រភាសាខ្មែរ (`km`) ជាលំនាំដើមជាមួយពុម្ពអក្សរ `Noto Sans Khmer` និងភាសាអង់គ្លេស (`en`) ជាមួយ `Inter`។
- **Dual-Currency Financial Ledger:** កត់ត្រា និងគណនាចំណូល-ចំណាយដាច់ដោយឡែកគ្នារវាងប្រាក់ដុល្លារ (**USD $**) និងប្រាក់រៀល (**KHR ៛**) ដោយគ្មានការបាត់បង់ភាពជាក់លាក់។
- **iPhone 14 Pro Max Mobile Optimization:** គាំទ្រអេក្រង់ទូរស័ព្ទ (430×932 CSS px) ជាមួយ Safe Area Top (`pt-safe` សម្រាប់ Dynamic Island) និង Safe Area Bottom (`pb-safe` សម្រាប់ Home Indicator) ព្រមទាំង 5-Tab Sticky Bottom Navigation។
- **Desktop Sidebar Navigation:** អេក្រង់កុំព្យូទ័រ (1280px+) បំពាក់ដោយ Fixed Collapsible Sidebar គ្រប់គ្រងទាំង ១៣ ម៉ូឌុលយ៉ាងងាយស្រួល។
- **Interactive Visualizations:** ក្រាហ្វិកវិភាគទិន្នន័យតាមរយៈ Chart.js (Cash Flow, Task Velocity, Study Hours)។

---

## 2. ម៉ូឌុលស្នូលទាំង ១២ (The 12 Core Modules)

1. **Dashboard (ផ្ទាំងគ្រប់គ្រង):** កាតសង្ខេប KPI សរុបចំនួន ៦, ក្រាហ្វិកលំហូរសាច់ប្រាក់ប្រចាំខែ, ក្រាហ្វិកស្ថានភាពកិច្ចការ, កាលវិភាគថ្ងៃនេះ និងភារកិច្ចបន្ទាន់។
2. **Personal Profile (ប្រវត្តិរូបផ្ទាល់ខ្លួន):** គ្រប់គ្រងរូបថតគណនី, ជីវប្រវត្តិសង្ខេប (Bio), ថ្ងៃខែឆ្នាំកំណើត, ភេទ, មុខរបរ និងអាសយដ្ឋាន។
3. **Daily Schedule (កាលវិភាគប្រចាំថ្ងៃ):** គ្រប់គ្រង Timeline សកម្មភាព, ម៉ោងចាប់ផ្តើម-បញ្ចប់, គណនារយៈពេលស្វ័យប្រវត្ត (Minutes), និងប្តូរស្ថានភាព Planned/Done ភ្លាមៗ។
4. **Daily Tasks (កិច្ចការប្រចាំថ្ងៃ):** គ្រប់គ្រងភារកិច្ចតាមអាទិភាព (🔥 ខ្ពស់, ⚡ មធ្យម, 🌱 ទាប), ច្រោះតាមប្រភេទ (ផ្ទាល់ខ្លួន, ការងារ, ការសិក្សា) និង Deadline។
5. **Daily Expenses (ចំណូល & ចំណាយ):** បញ្ជីកត់ត្រាហិរញ្ញវត្ថុទ្វេរូបិយប័ណ្ណ (USD/KHR), វិធីសាស្រ្តទូទាត់ (សាច់ប្រាក់, ធនាគារ, កាត, កាបូប ABA/Bakong), និងទាញយកទិន្នន័យជា CSV។
6. **Monthly Goals (គោលដៅប្រចាំខែ):** កំណត់គោលដៅប្រចាំខែ/ឆ្នាំ, បង្ហាញរបារវឌ្ឍនភាព (Progress Bar), និងកត់ត្រាកំណត់ហេតុវឌ្ឍនភាព (Milestone Logs)។
7. **Study Planner (ផែនការសិក្សា):** គ្រប់គ្រងមុខវិជ្ជាសិក្សា, កត់ត្រាម៉ោងរៀន (Study Sessions), គណនាម៉ោងរៀនសរុប (Total Hours), និងកំណត់ចំណាំមេរៀន។
8. **Work Activities (សកម្មភាពការងារ):** តាមដានផលិតភាពការងារ (Deep Work Hours), បញ្ជីភារកិច្ចការងារ (Deliverables), និងកាលវិភាគការងារប្រចាំថ្ងៃ។
9. **Habit Tracker (តាមដានទម្លាប់ល្អ):** តារាងពិនិត្យទម្លាប់ ៧ ថ្ងៃចុងក្រោយ (7-Day Check-in Bubbles), និងប្រព័ន្ធរាប់ចំនួនថ្ងៃជាប់ៗគ្នា (Streak Counters 🔥)។
10. **Skills Development (អភិវឌ្ឍន៍ជំនាញ):** កំណត់កម្រិតជំនាញ (Level 1 ដល់ Level 5 Stars), និងកត់ត្រាម៉ោងអនុវត្តជាក់ស្តែង (Practice Logs)។
11. **Personal Notes (កំណត់ត្រាផ្ទាល់ខ្លួន):** កត់ត្រាគំនិតរហ័ស (Quick Ideas), មុខងារខ្ទាស់កំណត់ត្រាសំខាន់ៗ (Pinned Notes), និងប្រព័ន្ធស្វែងរកពាក្យគន្លឹះ (Full-Text Search)។
12. **Reports & Analytics (របាយការណ៍):** វិភាគស្ថិតិស៊ីជម្រៅ, ក្រាហ្វិកចំណូល-ចំណាយ ៦ ខែ, ម៉ោងសិក្សា, អត្រាសម្រេចភារកិច្ច, និងប៊ូតុងទាញយកទិន្នន័យ (UTF-8 BOM CSV Export)។

---

## 3. បច្ចេកវិទ្យា & ស្ថាបត្យកម្ម (Tech Stack & Architecture)

- **Backend:** Laravel 13.x (PHP 8.5)
- **Database:** PostgreSQL 18.1 (Local Database: `my_daily_life`)
  - PostgreSQL Extensions: `pg_trgm` (GIN Fuzzy Full-Text Indexing)
  - Generated Virtual Columns: `duration_minutes`
  - Foreign Keys: `CASCADE` សម្រាប់ User Data, `RESTRICT` សម្រាប់ Financial Categories & Subjects
- **Frontend:** Blade Templates, Tailwind CSS v4, Alpine.js v3, Chart.js v4, Lucide Icons
- **Build Tool:** Vite v8

---

## 4. ការដំឡើង និងដំណើរការក្នុងម៉ាស៊ីនផ្ទាល់ (Local Setup Guide)

### លក្ខខណ្ឌតម្រូវ (Prerequisites):
- PHP 8.4+ ឬ PHP 8.5 (បំពាក់ Extension: `intl`, `pdo_pgsql`, `mbstring`, `fileinfo`, `gd`, `zip`)
- Composer 2.x
- PostgreSQL 16+ ឬ 18+
- Node.js 20+ និង npm

### ជំហានដំឡើង (Step-by-step Setup):

1. **ទាញយក Codebase និងចូលទៅកាន់ថតគម្រោង:**
   ```bash
   git clone <repository_url> my-daily-life
   cd my-daily-life
   ```

2. **ដំឡើង PHP Dependencies:**
   ```bash
   composer install
   ```

3. **ដំឡើង Node.js Dependencies & Build Frontend:**
   ```bash
   npm install
   npm run build
   ```

4. **កំណត់ឯកសារ `.env`:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *កំណត់ព័ត៌មាន PostgreSQL ក្នុង `.env`:*
   ```ini
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=my_daily_life
   DB_USERNAME=mdl_user
   DB_PASSWORD=your_password
   ```

5. **ដំណើរការ Database Migrations & Initial Data Seeder:**
   ```bash
   php artisan migrate
   ```

6. **បង្កើត Symbolic Link សម្រាប់ Upload រូបថត:**
   ```bash
   php artisan storage:link
   ```

7. **បើកដំណើរការ Local Development Server:**
   ```bash
   php artisan serve
   ```
   ចូលទៅកាន់កម្មវិធីតាមរយៈ: `http://127.0.0.1:8000`

---

## 5. ស្ថាបត្យកម្មមូលដ្ឋានទិន្នន័យ (Database Architecture & Migrations)

ប្រព័ន្ធមូលដ្ឋានទិន្នន័យត្រូវបានរចនាឡើងយ៉ាងម៉ត់ចត់ជាមួយ **២៥ តារាង (25 Tables)**:
- `users`, `password_reset_tokens`, `sessions`, `profiles`, `settings`
- `categories` (គាំទ្រជំពូកទ្វេភាសាខ្មែរ-អង់គ្លេស ចំនួន ៣១ ជំពូកដែលត្រូវបានបង្កើតដោយស្វ័យប្រវត្ត)
- `activities`, `tasks`
- `transactions` (តារាងហិរញ្ញវត្ថុគាំទ្រទ្វេរូបិយប័ណ្ណ USD/KHR)
- `goals`, `goal_progress_logs`
- `subjects`, `study_sessions`
- `habits`, `habit_logs`
- `skills`, `skill_activities`
- `notes`

---

## 6. ការធ្វើតេស្តស្វ័យប្រវត្ត (Automated Testing & QA)

គម្រោងនេះមាន Test Suite គ្របដណ្តប់ ១០០% លើមុខងារស្នូលទាំងអស់:
```powershell
$env:DB_CONNECTION = "pgsql"
$env:DB_DATABASE = "my_daily_life"
php -d extension=intl artisan test
```

### លទ្ធផលតេស្តបច្ចុប្បន្ន (Current Test Results):
```
PASS  Tests\Feature\BackendCrudTest (6 tests, 27 assertions)
PASS  Tests\Feature\FrontendViewsTest (2 tests, 30 assertions)
PASS  Tests\Feature\EndToEndQaTest (4 tests, 25 assertions)
PASS  Tests\Feature\ExampleTest (2 tests, 3 assertions)
PASS  Tests\Unit\ExampleTest (1 test, 1 assertion)

Total Tests: 15 passed (100%) | 86 assertions | 0 failures | 0 errors
```

---

## 7. ការដាក់ឱ្យប្រើប្រាស់ក្នុង Production (Deployment & Runbook)

នៅក្នុងថត `deployment/` មាន Script និង Template សម្រាប់ប្រើប្រាស់លើ Production Server រួចជាស្រេច:
- [`deployment/deploy.sh`](deployment/deploy.sh): Script សម្រាប់ Update និង Deploy កូដស្វ័យប្រវត្ត (Zero-Downtime Deployment)
- [`deployment/nginx.conf.example`](deployment/nginx.conf.example): ការកំណត់ Nginx Reverse Proxy ជាមួយ HTTPS (Let's Encrypt), Gzip និង Security Headers
- [`deployment/supervisor.conf.example`](deployment/supervisor.conf.example): ការកំណត់ Supervisor គ្រប់គ្រង Queue Worker
- [`deployment/backup.sh`](deployment/backup.sh): Script បម្រុងទុកទិន្នន័យ PostgreSQL (`pg_dump` + Gzip) រៀងរាល់យប់ ព្រមទាំងលុបឯកសារចាស់លើសពី ១៤ ថ្ងៃ

### ដំណើរការ Deploy លើ Server:
```bash
chmod +x deployment/deploy.sh deployment/backup.sh
./deployment/deploy.sh
```

---

## 8. ដំណោះស្រាយបញ្ហាទូទៅ (Troubleshooting Guide)

1. **បញ្ហា PHP Path នៅលើ Windows (PowerShell):**  
   ប្រសិនបើ Windows ចាប់យក PHP ចាស់របស់ XAMPP សូមដំណើរការ:
   ```powershell
   $env:Path = "C:\php85;" + $env:Path
   php -v
   ```

2. **បញ្ហា `ext/php_intl.dll` មិនទាន់បើកក្នុង `php.ini`:**  
   ដើម្បី format លេខ និងរូបិយប័ណ្ណ សូមបើក `extension=intl` ក្នុង `C:\php85\php.ini` ឬបន្ថែម flag:
   ```powershell
   php -d extension=intl artisan ...
   ```

3. **បញ្ហាការតភ្ជាប់ PostgreSQL ក្នុង Sandbox Mode:**  
   នៅលើ Windows ការតភ្ជាប់ Socket TCP ទៅកាន់ `127.0.0.1:5432` ត្រូវដំណើរការជាមួយ `BypassSandbox: true`។

4. **អក្សរខ្មែរខូចនៅពេលបើក CSV ក្នុង Excel:**  
   ប្រព័ន្ធបានបង្កប់ **UTF-8 BOM** (`\xEF\xBB\xBF`) នៅដើម Stream នៃឯកសារ CSV រួចជាស្រេច ធានាថា Microsoft Excel បង្ហាញអក្សរខ្មែរបានត្រឹមត្រូវ ១០០% ដោយមិនបាច់ប្តូរ Encoding ដោយដៃឡើយ។

---

## 📄 អាជ្ញាប័ណ្ណ (License)

គម្រោងនេះស្ថិតនៅក្រោមអាជ្ញាប័ណ្ណ **MIT License**។
រក្សាសិទ្ធិគ្រប់យ៉ាង © 2026 **Dara Chhoeun** (ជីវិតប្រចាំថ្ងៃរបស់ខ្ញុំ — My Daily Life)។
