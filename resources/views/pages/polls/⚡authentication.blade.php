<?php

use Livewire\Component;
use App\Models\Poll;
use Mary\Traits\Toast;

new class extends Component {
    public string $password = '';
    public $poll;
    use Toast;

    public function mount($poll)
    {
        $this->poll = Poll::where('public_id', $poll)->first();
    }

    public function checkPassword()
    {

        if (Hash::check($this->password, $this->poll->password)) {
            session()->put('poll_passwords.' . $this->poll->id . '.expiration', now()->addDays(config('poll.password_expiration_days')));
            //return redirect()->route('polls.show', $this->poll);
            $this->success(
                title: __('You have successfully entered the password!'),
                redirectTo: route('polls.show', $this->poll)
            );

        }
        else {
            $this->error(
                title: __('pages/poll-show.messages.errors.wrong_password'),
                position: 'toast-bottom toast-end'
            );
        }

    }
};
?>

<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ $poll->title }} - authentication</x-slot>

    <x-ui.card class="mb-1">
        <h2 class="text-2xl">{{ $poll->title }} - authentication</h2>
    </x-ui.card>

    @island
    <x-ui.card>
        <p class="text-sm font-light text-gray-500">{{ __('pages/password.text') }}</p>
        <form wire:submit.prevent="checkPassword()">
            <div class="mb-3">
                <x-mary-input id="password"
                              label="{{ __('pages/password.labels.password') }}"
                              type="password"
                              name="password"
                              wire:model="password"
                              required/>
            </div>
            <x-mary-button class="btn-primary"
                           type="submit"
                           label="{{ __('pages/password.buttons.submit') }}"
                           spinner />
        </form>

        @if(session()->has('error'))
            <x-ui.alert type="error">
                {{ session('error') }}
            </x-ui.alert>
        @endif
    </x-ui.card>
    @endisland


</x-layouts.app>
