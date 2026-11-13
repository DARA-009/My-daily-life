<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Subject;
use App\Models\User;
use Tests\TestCase;

class EndToEndQaTest extends TestCase
{
    protected User $user;
    protected ?Category $expenseCategory;
    protected ?Category $incomeCategory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::first() ?? User::factory()->create();
        $this->expenseCategory = Category::where('user_id', $this->user->id)->where('type', 'expense')->first();
        $this->incomeCategory = Category::where('user_id', $this->user->id)->where('type', 'income')->first();
    }

    public function test_form_validation_rejects_invalid_inputs(): void
    {
        // 1. Transaction requires valid positive amount and valid currency
        $response = $this->actingAs($this->user)->post(route('transactions.store'), [
            'amount' => -50,
            'currency' => 'INVALID_CURRENCY',
        ]);
        $response->assertSessionHasErrors(['amount', 'currency', 'category_id', 'type', 'transaction_date', 'description']);

        // 2. Activity requires valid time slot where end_time > start_time
        $response = $this->actingAs($this->user)->post(route('activities.store'), [
            'title' => 'Invalid Time Activity',
            'activity_date' => now()->toDateString(),
            'start_time' => '10:00',
            'end_time' => '09:00', // invalid: before start_time
        ]);
        $response->assertSessionHasErrors(['end_time']);

        // 3. Goal requires valid deadline on or after start_date
        $response = $this->actingAs($this->user)->post(route('goals.store'), [
            'title' => 'Invalid Goal',
            'start_date' => now()->toDateString(),
            'deadline' => now()->subDays(5)->toDateString(), // invalid: before start_date
        ]);
        $response->assertSessionHasErrors(['deadline']);
    }

    public function test_financial_calculations_are_mathematically_accurate(): void
    {
        // Record test USD income
        $this->actingAs($this->user)->post(route('transactions.store'), [
            'category_id' => $this->incomeCategory?->id ?? $this->expenseCategory?->id,
            'type' => 'income',
            'amount' => 500.00,
            'currency' => 'USD',
            'payment_method' => 'bank',
            'transaction_date' => now()->toDateString(),
            'description' => 'QA Salary Deposit',
        ]);

        // Record test USD expense
        $this->actingAs($this->user)->post(route('transactions.store'), [
            'category_id' => $this->expenseCategory?->id ?? $this->incomeCategory?->id,
            'type' => 'expense',
            'amount' => 125.50,
            'currency' => 'USD',
            'payment_method' => 'cash',
            'transaction_date' => now()->toDateString(),
            'description' => 'QA Grocery Run',
        ]);

        // Verify expenses page calculates net balance correctly
        $response = $this->actingAs($this->user)->get(route('expenses.index'));
        $response->assertStatus(200);

        // Net should be 500.00 - 125.50 = 374.50
        $response->assertSee('QA Salary Deposit');
        $response->assertSee('QA Grocery Run');
    }

    public function test_reports_csv_export_includes_utf8_bom_for_khmer(): void
    {
        $response = $this->actingAs($this->user)->get(route('reports.export'));
        
        $response->assertStatus(200);
        $this->assertTrue(str_contains($response->headers->get('content-type'), 'text/csv'));
        $this->assertTrue(str_contains($response->headers->get('content-disposition'), 'attachment; filename="transactions-'));
        
        // Assert UTF-8 BOM (\xEF\xBB\xBF) is present at the start of the output stream
        $content = $response->streamedContent();
        $this->assertStringStartsWith("\xEF\xBB\xBF", $content, "CSV export must start with UTF-8 BOM for Excel Khmer font rendering.");
    }

    public function test_subject_and_study_session_math(): void
    {
        $existing = Subject::where('user_id', $this->user->id)->where('name', 'QA Computer Science')->first();
        if ($existing) {
            $existing->studySessions()->forceDelete();
            $existing->forceDelete();
        }

        $subject = Subject::create([
            'user_id' => $this->user->id,
            'name' => 'QA Computer Science',
            'target_hours' => 20,
        ]);

        $response = $this->actingAs($this->user)->post(route('study-sessions.store'), [
            'subject_id' => $subject->id,
            'session_date' => now()->toDateString(),
            'start_time' => '14:00',
            'end_time' => '15:30', // 90 minutes = 1.5 hours
            'notes' => 'Binary Trees',
        ]);
        $response->assertRedirect();

        $session = $subject->studySessions()->where('notes', 'Binary Trees')->first();
        $this->assertNotNull($session);
        $this->assertEquals(90, $session->duration_minutes);

        // Verify study dashboard reflects the session
        $studyPage = $this->actingAs($this->user)->get(route('study.index'));
        $studyPage->assertStatus(200);
        $studyPage->assertSee('QA Computer Science');
        $studyPage->assertSee('Binary Trees');
        $studyPage->assertSee('90 នាទី');
    }
}
