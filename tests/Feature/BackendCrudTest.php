<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Category;
use App\Models\Goal;
use App\Models\Habit;
use App\Models\Note;
use App\Models\Task;
use App\Models\Transaction;
use App\Models\User;
use Tests\TestCase;

class BackendCrudTest extends TestCase
{
    protected User $user;
    protected ?Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::first() ?? User::factory()->create();
        $this->category = Category::where('user_id', $this->user->id)->first();
    }

    public function test_authenticated_user_can_create_and_toggle_activity(): void
    {
        $response = $this->actingAs($this->user)->post(route('activities.store'), [
            'category_id' => $this->category?->id,
            'title' => 'Feature Test Gym Activity',
            'activity_date' => now()->toDateString(),
            'start_time' => '07:00',
            'end_time' => '08:30',
            'status' => 'planned',
            'is_work' => false,
        ]);

        $response->assertRedirect();

        $activity = Activity::where('user_id', $this->user->id)
            ->where('title', 'Feature Test Gym Activity')
            ->latest()
            ->first();

        $this->assertNotNull($activity);
        $this->assertEquals('planned', $activity->status);

        // Test toggle (planned -> done)
        $toggleResponse = $this->actingAs($this->user)->patch(route('activities.toggle', $activity));
        $toggleResponse->assertRedirect();

        $activity->refresh();
        $this->assertEquals('done', $activity->status);
    }

    public function test_authenticated_user_can_create_and_toggle_task(): void
    {
        $response = $this->actingAs($this->user)->post(route('tasks.store'), [
            'title' => 'Feature Test High Priority Task',
            'priority' => 'high',
            'due_date' => now()->toDateString(),
            'category_id' => $this->category?->id,
            'description' => 'Automated test task description',
        ]);

        $response->assertRedirect();

        $task = Task::where('user_id', $this->user->id)
            ->where('title', 'Feature Test High Priority Task')
            ->latest()
            ->first();

        $this->assertNotNull($task);
        $this->assertEquals('pending', $task->status);

        // Test toggle (pending -> completed)
        $toggleResponse = $this->actingAs($this->user)->patch(route('tasks.toggle', $task));
        $toggleResponse->assertRedirect();

        $task->refresh();
        $this->assertEquals('completed', $task->status);
    }

    public function test_authenticated_user_can_create_transaction(): void
    {
        $expenseCategory = Category::where('user_id', $this->user->id)
            ->where('type', 'expense')
            ->first() ?? $this->category;

        $response = $this->actingAs($this->user)->post(route('transactions.store'), [
            'category_id' => $expenseCategory?->id,
            'type' => 'expense',
            'amount' => 15.75,
            'currency' => 'USD',
            'transaction_date' => now()->toDateString(),
            'payment_method' => 'cash',
            'description' => 'Feature Test Coffee & Snacks',
        ]);

        $response->assertRedirect();

        $txn = Transaction::where('user_id', $this->user->id)
            ->where('description', 'Feature Test Coffee & Snacks')
            ->latest()
            ->first();

        $this->assertNotNull($txn);
        $this->assertEquals(15.75, (float)$txn->amount);
        $this->assertEquals('USD', $txn->currency);
    }

    public function test_authenticated_user_can_create_goal_and_log_progress(): void
    {
        $response = $this->actingAs($this->user)->post(route('goals.store'), [
            'title' => 'Feature Test Read 10 Books',
            'target_year' => now()->year,
            'target_month' => now()->month,
            'start_date' => now()->toDateString(),
            'deadline' => now()->addMonths(6)->toDateString(),
            'priority' => 'high',
            'progress_percent' => 0,
            'status' => 'in_progress',
        ]);

        $response->assertRedirect();

        $goal = Goal::where('user_id', $this->user->id)
            ->where('title', 'Feature Test Read 10 Books')
            ->latest()
            ->first();

        $this->assertNotNull($goal);

        // Log progress
        $progResponse = $this->actingAs($this->user)->post(route('goals.progress.store', $goal), [
            'progress_percent' => 35,
            'logged_on' => now()->toDateString(),
            'note' => 'Finished 3 chapters',
        ]);

        $progResponse->assertRedirect();

        $goal->refresh();
        $this->assertEquals(35, (int)$goal->progress_percent);
    }

    public function test_authenticated_user_can_create_habit_and_log_checkin(): void
    {
        $response = $this->actingAs($this->user)->post(route('habits.store'), [
            'name' => 'Feature Test Morning Meditation',
            'frequency' => 'daily',
            'target_per_week' => 7,
            'start_date' => now()->toDateString(),
        ]);

        $response->assertRedirect();

        $habit = Habit::where('user_id', $this->user->id)
            ->where('name', 'Feature Test Morning Meditation')
            ->latest()
            ->first();

        $this->assertNotNull($habit);

        // Toggle habit checkin
        $logResponse = $this->actingAs($this->user)->post(route('habits.toggle', $habit), [
            'log_date' => now()->toDateString(),
        ]);

        $logResponse->assertRedirect();

        $hasLog = $habit->logs()
            ->whereDate('log_date', now()->toDateString())
            ->exists();

        $this->assertTrue($hasLog);
    }

    public function test_authenticated_user_can_create_and_pin_note(): void
    {
        $response = $this->actingAs($this->user)->post(route('notes.store'), [
            'title' => 'Feature Test Architecture Spec',
            'content' => 'Documenting Laravel 13 backend architecture and endpoints.',
            'is_pinned' => false,
        ]);

        $response->assertRedirect();

        $note = Note::where('user_id', $this->user->id)
            ->where('title', 'Feature Test Architecture Spec')
            ->latest()
            ->first();

        $this->assertNotNull($note);
        $this->assertFalse((bool)$note->is_pinned);

        // Pin note
        $pinResponse = $this->actingAs($this->user)->patch(route('notes.pin', $note));
        $pinResponse->assertRedirect();

        $note->refresh();
        $this->assertTrue((bool)$note->is_pinned);
    }
}
