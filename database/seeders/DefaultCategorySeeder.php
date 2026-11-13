<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DefaultCategorySeeder extends Seeder
{
    /**
     * type => [system_key => Khmer name]. The English names live in lang/en/categories.php.
     */
    public const DEFAULTS = [
        'activity' => [
            'work' => 'ការងារ', 'study' => 'សិក្សា', 'health' => 'សុខភាព',
            'personal' => 'ផ្ទាល់ខ្លួន', 'other' => 'ផ្សេងៗ',
        ],
        'task' => [
            'work' => 'ការងារ', 'study' => 'សិក្សា', 'personal' => 'ផ្ទាល់ខ្លួន',
            'home' => 'ផ្ទះ', 'other' => 'ផ្សេងៗ',
        ],
        'income' => [
            'salary' => 'ប្រាក់ខែ', 'freelance' => 'ការងារឯករាជ្យ',
            'gift' => 'អំណោយ', 'other' => 'ផ្សេងៗ',
        ],
        'expense' => [
            'food' => 'អាហារ', 'transport' => 'ធ្វើដំណើរ', 'shopping' => 'ទិញឥវ៉ាន់',
            'utilities' => 'ទឹក ភ្លើង អ៊ីនធឺណិត', 'health' => 'សុខភាព',
            'education' => 'ការសិក្សា', 'entertainment' => 'កម្សាន្ត', 'other' => 'ផ្សេងៗ',
        ],
        'note' => [
            'personal' => 'ផ្ទាល់ខ្លួន', 'work' => 'ការងារ', 'ideas' => 'គំនិត', 'other' => 'ផ្សេងៗ',
        ],
        'skill' => [
            'design' => 'ការរចនាក្រាហ្វិក', 'language' => 'ភាសា',
            'programming' => 'ការសរសេរកម្មវិធី', 'soft_skills' => 'ជំនាញទន់', 'other' => 'ផ្សេងៗ',
        ],
    ];

    /** Seeds the default categories for every existing user (safe to run more than once). */
    public function run(): void
    {
        User::query()->each(fn (User $user) => self::seedFor($user));
    }

    /** Call this right after a new user registers. */
    public static function seedFor(User $user): void
    {
        foreach (self::DEFAULTS as $type => $items) {
            foreach ($items as $systemKey => $name) {
                $user->categories()->firstOrCreate(
                    ['type' => $type, 'system_key' => $systemKey],
                    ['name' => $name],
                );
            }
        }
    }
}
