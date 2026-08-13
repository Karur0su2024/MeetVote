<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Volt\Volt;
use Tests\TestCase;
use App\Models\Poll;

class PollAuthenticationTest extends TestCase
{
    public function test_poll_authentication_password_is_right(): void
    {
        $poll = Poll::factory()->create(['password' => bcrypt('password')]);
        $component = Volt::test('pages::polls.authentication', ['poll' => $poll->public_id]);
        $component->set('password', "password");
        $component->call('checkPassword');
        $component->assertHasNoErrors()->assertRedirect(route('polls.show', $poll->public_id));
    }

    public function test_poll_authentication_password_is_wrong(): void
    {
        $poll = Poll::factory()->create(['password' => bcrypt('password')]);
        $component = Volt::test('pages::polls.authentication', ['poll' => $poll->public_id]);
        $component->set('password', "password123");
        $component->call('checkPassword');
        $component->assertHasErrors()
            ->assertNoRedirect();

    }
}
