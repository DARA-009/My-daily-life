<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Category;
use App\Models\Goal;
use App\Models\Habit;
use App\Models\Note;
use App\Models\Skill;
use App\Models\Subject;
use App\Models\Task;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        if (!$user) {
            $this->command->error("No user found. Please register or seed a user first.");
            return;
        }

        $this->command->info("Seeding realistic demo data for user: {$user->name} ({$user->email})...");

        $today = Carbon::today();
        $categories = Category::where('user_id', $user->id)->get()->groupBy('type');

        $activityCat = $categories->get('activity', collect())->first();
        $taskCat = $categories->get('task', collect())->first();
        $incomeCat = $categories->get('income', collect())->first();
        $expenseCat = $categories->get('expense', collect())->first();
        $workCat = $categories->get('activity', collect())->firstWhere('name', 'ការងារ') ?? $activityCat;

        // 1. Daily Schedule Activities (Today)
        $activities = [
            [
                'title' => 'ហាត់ប្រាណពេលព្រឹក & រត់កម្សាន្ត (Morning Jogging)',
                'category_id' => $activityCat?->id,
                'activity_date' => $today->toDateString(),
                'start_time' => '06:30',
                'end_time' => '07:30',
                'status' => 'done',
                'description' => 'រត់ ៥ គីឡូម៉ែត្រនៅពហុកីឡដ្ឋានជាតិអូឡាំពិក។',
            ],
            [
                'title' => 'Deep Work: សរសេរកូដប្រព័ន្ធ Laravel Backend API',
                'category_id' => $workCat?->id,
                'activity_date' => $today->toDateString(),
                'start_time' => '08:30',
                'end_time' => '11:30',
                'status' => 'done',
                'description' => 'បញ្ចប់ Feature Authentication, Middleware, and Database Optimization.',
            ],
            [
                'title' => 'ពិភាក្សាគម្រោងជាមួយក្រុមការងារ (Team Sync)',
                'category_id' => $workCat?->id,
                'activity_date' => $today->toDateString(),
                'start_time' => '14:00',
                'end_time' => '15:00',
                'status' => 'planned',
                'description' => 'រៀបចំផែនការ Sprint បន្ទាប់ និងការត្រួតពិនិត្យ Architecture.',
            ],
            [
                'title' => 'សិក្សាស្រាវជ្រាវ AI Agentic Systems & PostgreSQL 18',
                'category_id' => $activityCat?->id,
                'activity_date' => $today->toDateString(),
                'start_time' => '16:00',
                'end_time' => '17:30',
                'status' => 'planned',
                'description' => 'អានឯកសារបច្ចេកទេស និងអនុវត្តជាក់ស្តែងលើ Vector/GIN Indexing.',
            ],
        ];

        foreach ($activities as $act) {
            Activity::updateOrCreate(
                ['user_id' => $user->id, 'title' => $act['title'], 'activity_date' => $act['activity_date']],
                $act
            );
        }

        // 2. Tasks
        $tasks = [
            [
                'title' => 'ដាក់ឱ្យដំណើរការប្រព័ន្ធ My Daily Life លើ Production Server',
                'kind' => 'work',
                'priority' => 'high',
                'status' => 'in_progress',
                'due_date' => $today->copy()->addDays(2)->toDateString(),
                'progress_percent' => 85,
                'category_id' => $taskCat?->id,
                'description' => 'រៀបចំ Nginx HTTP/2, Let\'s Encrypt SSL, និង Supervisor daemon.',
            ],
            [
                'title' => 'សរសេរឯកសារជំនួយការប្រើប្រាស់ (User Guide & Runbook)',
                'kind' => 'work',
                'priority' => 'medium',
                'status' => 'completed',
                'completed_at' => $today->copy()->subDay(),
                'due_date' => $today->toDateString(),
                'progress_percent' => 100,
                'category_id' => $taskCat?->id,
                'description' => 'បង្កើត README.md ជាភាសាខ្មែរ និងអង់គ្លេសយ៉ាងលម្អិត។',
            ],
            [
                'title' => 'អានសៀវភៅ Atomic Habits ឱ្យចប់ជំពូកទី ៥',
                'kind' => 'personal',
                'priority' => 'medium',
                'status' => 'pending',
                'due_date' => $today->copy()->addDays(3)->toDateString(),
                'progress_percent' => 40,
                'category_id' => $taskCat?->id,
                'description' => 'អនុវត្តវិធីសាស្ត្រ Habit Stacking ក្នុងជីវិតជាក់ស្តែង។',
            ],
            [
                'title' => 'ត្រៀមសំណួរ និងឯកសារសម្រាប់ប្រជុំវាយតម្លៃប្រចាំខែ',
                'kind' => 'study',
                'priority' => 'high',
                'status' => 'pending',
                'due_date' => $today->copy()->addDay()->toDateString(),
                'progress_percent' => 20,
                'category_id' => $taskCat?->id,
                'description' => 'សង្ខេបលទ្ធផល និងទិន្នន័យផលិតភាពការងារ។',
            ],
        ];

        foreach ($tasks as $t) {
            Task::updateOrCreate(
                ['user_id' => $user->id, 'title' => $t['title']],
                $t
            );
        }

        // 3. Transactions (Dual-Currency: USD & KHR)
        $transactions = [
            [
                'type' => 'income',
                'amount' => 1250.00,
                'currency' => 'USD',
                'payment_method' => 'bank',
                'transaction_date' => $today->copy()->startOfMonth()->toDateString(),
                'description' => 'ប្រាក់បៀវត្សរ៍ប្រចាំខែ (Monthly Salary)',
                'category_id' => $incomeCat?->id,
            ],
            [
                'type' => 'income',
                'amount' => 600000.00,
                'currency' => 'KHR',
                'payment_method' => 'mobile_wallet',
                'transaction_date' => $today->copy()->subDays(5)->toDateString(),
                'description' => 'ចំណូលពីការងារ Freelance (Consulting)',
                'category_id' => $incomeCat?->id,
            ],
            [
                'type' => 'expense',
                'amount' => 38.50,
                'currency' => 'USD',
                'payment_method' => 'card',
                'transaction_date' => $today->copy()->subDays(2)->toDateString(),
                'description' => 'ទិញម្ហូបអាហារ និងបន្លែសរីរាង្គ (Supermarket)',
                'category_id' => $expenseCat?->id,
            ],
            [
                'type' => 'expense',
                'amount' => 45000.00,
                'currency' => 'KHR',
                'payment_method' => 'mobile_wallet',
                'transaction_date' => $today->copy()->subDays(1)->toDateString(),
                'description' => 'ចាក់សាំងរថយន្ត / ម៉ូតូ (Fuel)',
                'category_id' => $expenseCat?->id,
            ],
            [
                'type' => 'expense',
                'amount' => 4.50,
                'currency' => 'USD',
                'payment_method' => 'mobile_wallet',
                'transaction_date' => $today->toDateString(),
                'description' => 'កាហ្វេពេលព្រឹក (Iced Americano & Croissant)',
                'category_id' => $expenseCat?->id,
            ],
            [
                'type' => 'expense',
                'amount' => 28000.00,
                'currency' => 'KHR',
                'payment_method' => 'cash',
                'transaction_date' => $today->toDateString(),
                'description' => 'បាយថ្ងៃត្រង់ជាមួយមិត្តរួមការងារ',
                'category_id' => $expenseCat?->id,
            ],
        ];

        foreach ($transactions as $txn) {
            Transaction::updateOrCreate(
                ['user_id' => $user->id, 'description' => $txn['description'], 'transaction_date' => $txn['transaction_date']],
                $txn
            );
        }

        // 4. Monthly Goals
        $goals = [
            [
                'title' => 'អានសៀវភៅឱ្យបាន ២ ក្បាលក្នុងខែនេះ',
                'target_year' => $today->year,
                'target_month' => $today->month,
                'start_date' => $today->copy()->startOfMonth()->toDateString(),
                'deadline' => $today->copy()->endOfMonth()->toDateString(),
                'priority' => 'high',
                'progress_percent' => 75,
                'status' => 'in_progress',
                'description' => 'អានចប់សៀវភៅទី ១ (Atomic Habits) និងកំពុងអានសៀវភៅទី ២ (Deep Work)។',
            ],
            [
                'title' => 'សន្សំប្រាក់ $400 ដាក់ក្នុង Emergency Fund',
                'target_year' => $today->year,
                'target_month' => $today->month,
                'start_date' => $today->copy()->startOfMonth()->toDateString(),
                'deadline' => $today->copy()->endOfMonth()->toDateString(),
                'priority' => 'high',
                'progress_percent' => 100,
                'status' => 'completed',
                'completed_at' => $today->copy()->subDays(2),
                'description' => 'ផ្ទេរប្រាក់សន្សំទៅកាន់គណនី Fixed Deposit ធនាគារដោយជោគជ័យ។',
            ],
            [
                'title' => 'រៀន និងបង្កើត Mini Project ជាមួយ Vue 3 / Inertia',
                'target_year' => $today->year,
                'target_month' => $today->month,
                'start_date' => $today->copy()->startOfMonth()->toDateString(),
                'deadline' => $today->copy()->endOfMonth()->toDateString(),
                'priority' => 'medium',
                'progress_percent' => 50,
                'status' => 'in_progress',
                'description' => 'យល់ដឹងពី Composition API, State Management, and TypeScript integration.',
            ],
        ];

        foreach ($goals as $g) {
            Goal::updateOrCreate(
                ['user_id' => $user->id, 'title' => $g['title'], 'target_year' => $g['target_year'], 'target_month' => $g['target_month']],
                $g
            );
        }

        // 5. Subjects & Study Sessions
        $subjects = [
            [
                'name' => 'Advanced Laravel & System Design',
                'target_hours' => 30,
                'learning_target' => 'ស្វែងយល់ពី Caching Strategy, Queue Architecture, and Database Indexing.',
            ],
            [
                'name' => 'English for Professional Presentations',
                'target_hours' => 20,
                'learning_target' => 'ពង្រឹងការនិយាយជាសាធារណៈ និងការធ្វើបទបង្ហាញបែបបច្ចេកវិទ្យា។',
            ],
        ];

        foreach ($subjects as $s) {
            $sub = Subject::updateOrCreate(
                ['user_id' => $user->id, 'name' => $s['name']],
                $s
            );

            // Create a sample study session
            $sub->studySessions()->updateOrCreate(
                [
                    'user_id' => $user->id,
                    'session_date' => $today->copy()->subDay()->toDateString(),
                    'start_time' => '19:00',
                    'end_time' => '20:30',
                ],
                [
                    'status' => 'completed',
                    'notes' => 'សិក្សាពី PostgreSQL GIN Indexes and Query Optimization.',
                ]
            );
        }

        // 6. Daily Habits & 7-Day Consistency Logs
        $habits = [
            [
                'name' => 'ផឹកទឹក ២ លីត្រជារៀងរាល់ថ្ងៃ (Drink 2L Water)',
                'frequency' => 'daily',
                'target_per_week' => 7,
                'start_date' => $today->copy()->subDays(14)->toDateString(),
                'description' => 'រក្សាជាតិទឹកក្នុងខ្លួនឱ្យបានគ្រប់គ្រាន់ ដើម្បីសុខភាពល្អ និងខួរក្បាលស្រឡះ។',
            ],
            [
                'name' => 'ហាត់ប្រាណពេលព្រឹក ៣០ នាទី (Exercise 30 mins)',
                'frequency' => 'daily',
                'target_per_week' => 7,
                'start_date' => $today->copy()->subDays(10)->toDateString(),
                'description' => 'ជួយបង្កើនថាមពលរាងកាយ និងកាត់បន្ថយភាពតានតឹង។',
            ],
            [
                'name' => 'អានសៀវភៅ ២០ ទំព័រមុនចូលគេង (Read 20 pages)',
                'frequency' => 'daily',
                'target_per_week' => 7,
                'start_date' => $today->copy()->subDays(20)->toDateString(),
                'description' => 'ពង្រីកចំណេះដឹង និងជួយឱ្យគេងលក់ស្រួល។',
            ],
        ];

        foreach ($habits as $h) {
            $habit = Habit::updateOrCreate(
                ['user_id' => $user->id, 'name' => $h['name']],
                $h
            );

            // Log check-ins for past 6 days + today
            for ($i = 0; $i <= 6; $i++) {
                // Vary check-in for realistic pattern (habit 1: all 7 days, habit 2: 5 days, habit 3: 6 days)
                if ($habit->name === $habits[1]['name'] && ($i === 2 || $i === 4)) {
                    continue;
                }
                $logDate = $today->copy()->subDays($i)->toDateString();
                $habit->logs()->updateOrCreate(
                    ['log_date' => $logDate],
                    ['note' => 'បានបំពេញតាមការគ្រោងទុក']
                );
            }
        }

        // 7. Skills
        $skills = [
            [
                'name' => 'PHP & Laravel Full-Stack',
                'current_level' => 4,
                'target_level' => 5,
                'description' => 'ការអភិវឌ្ឍ Web Applications និង API Architecture កម្រិតខ្ពស់។',
            ],
            [
                'name' => 'PostgreSQL Database Administration',
                'current_level' => 3,
                'target_level' => 5,
                'description' => 'ការរចនា Schema, Indexing Strategy, និង Query Performance Tuning។',
            ],
            [
                'name' => 'Modern Tailwind CSS & UI/UX Design',
                'current_level' => 4,
                'target_level' => 5,
                'description' => 'ការរចនាទម្រង់ Ergonomics សម្រាប់ទូរស័ព្ទ និង Desktop។',
            ],
        ];

        foreach ($skills as $sk) {
            Skill::updateOrCreate(
                ['user_id' => $user->id, 'name' => $sk['name']],
                $sk
            );
        }

        // 8. Personal Notes
        $notes = [
            [
                'title' => '📌 ផែនការយុទ្ធសាស្ត្រជីវិត និងការងារឆ្នាំ ២០២៦',
                'body' => "១. សុខភាព៖ ហាត់ប្រាណ ៥ ថ្ងៃ/សប្តាហ៍, គេងឱ្យបាន ៧-៨ ម៉ោង និងផឹកទឹកឱ្យបាន ២ លីត្ររាល់ថ្ងៃ។\n២. អាជីព៖ ក្លាយជា Senior Full-Stack Software Architect, ធ្វើជាម្ចាស់លើ Laravel 13, PostgreSQL, និង AI Agentic Systems។\n៣. ហិរញ្ញវត្ថុ៖ បង្កើនប្រាក់សន្សំ និងវិនិយោគលើការអភិវឌ្ឍសមត្ថភាពផ្ទាល់ខ្លួន។\n៤. ចំណេះដឹង៖ អានសៀវភៅឱ្យបានយ៉ាងតិច ១៥ ក្បាលក្នុងមួយឆ្នាំ។",
                'is_pinned' => true,
            ],
            [
                'title' => '💡 គំនិតកែលម្អប្រព័ន្ធ My Daily Life (Roadmap Ideas)',
                'body' => "- បន្ថែម PWA Web Manifest ឱ្យអាច Install លើ iPhone Home Screen ដោយគ្មាន Safari bar។\n- បន្ថែម Dark Mode Toggle តាមចំណូលចិត្តអ្នកប្រើប្រាស់។\n- រៀបចំប្រព័ន្ធ Notification Alerts តាមរយៈ Telegram Bot ឬ Web Push។",
                'is_pinned' => true,
            ],
            [
                'title' => 'កំណត់ត្រាប្រជុំ៖ ស្ថាបត្យកម្ម PostgreSQL Indexes',
                'body' => "លទ្ធផលនៃការពិភាក្សា៖\n- ប្រើប្រាស់ `pg_trgm` GIN index សម្រាប់ Fuzzy Search លើឈ្មោះ និងបរិយាយ។\n- ប្រើប្រាស់ B-Tree Composite Index លើ `(user_id, activity_date)` ដើម្បីបង្កើនល្បឿន Query កាលវិភាគ។\n- ប្រើប្រាស់ Foreign Key `RESTRICT` លើប្រភេទទិន្នន័យហិរញ្ញវត្ថុ ដើម្បីទប់ស្កាត់ការលុបដោយអចេតនា។",
                'is_pinned' => false,
            ],
        ];

        foreach ($notes as $n) {
            Note::updateOrCreate(
                ['user_id' => $user->id, 'title' => $n['title']],
                $n
            );
        }

        $this->command->info("Demo data seeding completed successfully! All 12 modules now have rich sample data.");
    }
}
