<?php

namespace Poll;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
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

    public function test_the_poll_can_be_created_by_an_authenticated_user(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test('pages.poll-editor')
            ->set($this->validPollData())->call('submit')
            ->assertHasNoErrors();

            $this->assertDatabaseHas('polls', [
                'title' => 'Test title',
                'description' => 'Test description',
            ]);

    }

    public function test_the_poll_can_be_created_by_a_guest(): void
    {
        $this->assertGuest();

        Livewire::test('pages.poll-editor')
            ->set($this->validPollData())
            ->set('form.user.name', 'Test user')
            ->set('form.user.email', 'guest@example.com')
            ->call('submit')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('polls', [
            'title' => 'Test title',
            'description' => 'Test description',
            'author_name' => 'Test user',
            'author_email' => 'guest@example.com',
            'user_id' => null
        ]);

    }

    public function test_the_poll_cant_be_created_without_a_title(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test('pages.poll-editor')
            ->set($this->validPollData())
            ->set('form.title', '')
            ->call('submit')
            ->assertHasErrors();

    }

    public function test_the_poll_cant_be_created_without_a_time_option(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test('pages.poll-editor')
            ->set($this->validPollData())
            ->set('form.dates', [
                '2026-11-10' => [

                ]
            ])
            ->call('submit')
            ->assertHasErrors();

    }

    public function test_the_poll_cant_be_created_with_duplicate_time_options(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test('pages.poll-editor')
            ->set($this->validPollData())
            ->set('form.dates', [
                '2026-11-10' => [
                    [
                        'type' => 'time',
                        'date' => '2026-11-10',
                        'content' => [
                            'start' => '10:00',
                            'end' => '11:00',
                        ],
                    ],
                    [
                        'type' => 'time',
                        'date' => '2026-11-10',
                        'content' => [
                            'start' => '10:00',
                            'end' => '11:00',
                        ],
                    ],
                ]
            ])
            ->call('submit')
            ->assertHasErrors();

    }

    public function test_the_poll_cant_be_created_with_invalid_deadline(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test('pages.poll-editor')
            ->set($this->validPollData())
            ->set('form.deadline', now()->addDay(-1))
            ->call('submit')
            ->assertHasErrors();

    }

    public function test_the_poll_cant_be_created_with_invalid_question(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test('pages.poll-editor')
            ->set($this->validPollData())
            ->set('form.questions', [
                [
                    'text' => 'Test question',
                    [
                        'text' => 'Test question',
                    ],
                    [
                        'text' => '',]
                ]
            ])
            ->call('submit')
            ->assertHasErrors();

    }

    private function validPollData(): array
    {
        return [
            'form' => [
                'title' => 'Test title',
                'description' => 'Test description',
                'deadline' => now()->addDay(),
                'dates' => [
                    '2026-11-10' => [
                        [
                            'type' => 'time',
                            'date' => '2026-11-10',
                            'content' => [
                                'start' => '10:00',
                                'end' => '11:00',
                            ],
                        ],
                        [
                            'type' => 'time',
                            'date' => '2026-11-10',
                            'content' => [
                                'start' => '12:00',
                                'end' => '13:00',
                            ],
                        ],
                        [
                            'type' => 'text',
                            'date' => '2026-11-10',
                            'content' => [
                                'text' => 'Test text',
                            ],
                        ],
                    ],
                    '2026-11-12' => [
                        [
                            'type' => 'time',
                            'date' => '2026-11-10',
                            'content' => [
                                'start' => '10:00',
                                'end' => '11:00',
                            ],
                        ],
                    ]
                ],
                'questions' => [
                    [
                        'text' => 'Test question',
                        'options' => [
                            [
                                'text' => 'Option 1',
                            ],
                            [
                                'text' => 'Option 2',
                            ]
                        ]
                    ]
                ],
                'settings' => [
                    'comments' => true,
                    'anonymous_votes' => true,
                    'hide_results' => false,
                    'invite_only' => false,
                    'add_time_options' => true,
                    'allow_invalid' => false,
                ],
                'password' => [
                    'enabled' => true,
                    'value' => 'password',
                    'set' => ''
                ]
            ]
        ];
    }
}
