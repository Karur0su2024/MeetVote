<?php

use Livewire\Component;
use App\Models\Poll;

new class extends Component {
    public $password = '';
    public $poll;

    public function mount($poll){
        $this->poll = Poll::findOrFail($poll);
    }

    public function checkPassword()
    {
        if (Hash::check($request->password, $poll->password)) {
            session()->put('poll_passwords.' . $poll->id . '.expiration', now()->addDays(config('poll.password_expiration_days')));

            return redirect()->route('polls.show', $poll);
        }

        return redirect()->back()->with('error', __('pages/poll-show.messages.errors.wrong_password'));
    }
};
?>

<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ $poll->title }}</x-slot>

    <x-ui.card>
        <h2>{{ $poll->title }}</h2>
    </x-ui.card>

    <x-ui.tw-card>
        <x-slot:title>
            {{ $poll->title }}
        </x-slot:title>

        @if(session()->has('error'))
            <x-ui.alert type="error">
                {{ session('error') }}
            </x-ui.alert>
        @endif
        <p>{{ __('pages/password.text') }}</p>
        <form wire:submit="checkPassword()" method="post">
            @csrf
            <div class="mb-3">
                <x-mary-input id="password"
                              label="{{ __('pages/password.labels.password') }}"
                              type="password"
                              name="password"
                              wire:model="password"
                              required/>

            </div>
            <button type="submit" class="tw:btn tw:btn-primary">{{ __('pages/password.buttons.submit') }}</button>
        </form>
    </x-ui.tw-card>

</x-layouts.app>
