<?php

namespace Tests\Feature\Poll;

use App\Models\Comment;
use App\Models\Poll;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Volt\Volt;
use Tests\TestCase;

class CommentTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_guest_can_add_comment(): void
    {
        $poll = Poll::factory()->create();

        $component = Volt::test('sections.poll-show.comments', ['pollIndex' => $poll->id]);
        $component->set([
            'username' => fake()->name,
            'content' => fake()->text,
        ]);
        $component->call('addComment');
        $component->assertHasNoErrors()->assertSee([
            'username' => '',
            'content' => '',
        ]);

    }

    public function test_user_can_add_comment(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $poll = Poll::factory()->create();

        $content = fake()->text();

        $component = Volt::test('sections.poll-show.comments', ['pollIndex' => $poll->id]);
        $component->set([
            'content' => $content,
        ]);
        $component->call('addComment');

        $comment = Comment::where('content', $content)->first();

        $this->assertDatabaseHas('comments', [
            'content' => $content,
        ]);

    }

    public function test_user_can_delete_their_comment(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $poll = Poll::factory()->create();
        $content = fake()->text();
        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'poll_id' => $poll->id,
            'author_name' => $user->name,
            'content' => $content,
        ]);

        $component = Volt::test('sections.poll-show.comments', ['pollIndex' => $poll->id]);

        $component->call('deleteComment', $comment->id);

        $component->assertHasNoErrors();
        $this->assertSoftDeleted('comments', [
            'content' => $content,
        ]);
    }

    public function test_nonowner_cant_delete_comment(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $poll = Poll::factory()->create();
        $content = fake()->text();
        $anotherUser = User::factory()->create();

        $comment = Comment::factory()->create([
            'user_id' => $anotherUser->id,
            'poll_id' => $poll->id,
            'author_name' => $anotherUser->name,
            'content' => $content,
        ]);

        $component = Volt::test('sections.poll-show.comments', ['pollIndex' => $poll->id]);

        $component->call('deleteComment', $comment->id)->assertForbidden();

    }
}
