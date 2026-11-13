<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class FrontendViewsTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::first() ?? User::factory()->create();
    }

    public function test_all_12_module_views_render_successfully(): void
    {
        $routes = [
            'dashboard'      => route('dashboard'),
            'profile'        => route('profile.index'),
            'settings'       => route('settings.index'),
            'schedule'       => route('schedule.index'),
            'tasks'          => route('tasks.index'),
            'work'           => route('work.index'),
            'expenses'       => route('expenses.index'),
            'goals'          => route('goals.index'),
            'study'          => route('study.index'),
            'habits'         => route('habits.index'),
            'skills'         => route('skills.index'),
            'notes'          => route('notes.index'),
            'reports'        => route('reports.index'),
        ];

        foreach ($routes as $name => $url) {
            $response = $this->actingAs($this->user)->get($url);
            $response->assertStatus(200);
            $this->assertNotEmpty($response->getContent(), "Route {$name} ({$url}) returned empty response.");
        }
    }

    public function test_locale_switching_updates_session_and_ui(): void
    {
        // Switch to English
        $responseEn = $this->actingAs($this->user)->get(route('locale.switch', 'en'));
        $responseEn->assertRedirect();
        $responseEn->assertSessionHas('locale', 'en');

        // Switch to Khmer
        $responseKm = $this->actingAs($this->user)->get(route('locale.switch', 'km'));
        $responseKm->assertRedirect();
        $responseKm->assertSessionHas('locale', 'km');
    }
}
