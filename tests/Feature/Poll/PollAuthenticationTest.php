<?php

namespace Poll;

use App\Models\Poll;
use Livewire\Volt\Volt;
use Tests\TestCase;

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

    public function test_poll_doesnt_exist(): void
    {
        $this->get(route('polls.authentication', ['poll' => '123']))
            ->assertNotFound();
    }

    public function test_poll_doesnt_have_password(): void
    {
        $poll = Poll::factory()->create(['password' => null]);

        $this->get(route('polls.authentication', $poll->public_id))
            ->assertRedirect(route('polls.show', $poll->public_id));
    }
}
