<?php

namespace Poll;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PollCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_open_the_poll_creation_page(): void
    {
        $this->withSession(['language' => 'en'])
            ->get(route('polls.create'))
            ->assertOk()
            ->assertSeeText(__('pages/poll-editor.page.create', [], 'en'))
            ->assertSeeLivewire('pages.poll-editor');
    }

    public function test_authenticated_users_can_open_the_poll_creation_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('polls.create'))
            ->assertOk()
            ->assertSeeLivewire('pages.poll-editor')
            ->assertSee($user->email);
    }

    public function test_the_page_uses_the_selected_language(): void
    {
        $this->withSession(['language' => 'cz'])
            ->get(route('polls.create'))
            ->assertOk()
            ->assertSeeText(__('pages/poll-editor.page.create', [], 'cz'))
            ->assertSeeLivewire('pages.poll-editor');
    }
}
