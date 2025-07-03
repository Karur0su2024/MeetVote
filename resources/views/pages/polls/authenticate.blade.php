<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ $poll->title }}</x-slot>

    <div class="container text-start">

        <x-ui.tw-card>
            <x-slot:title>
                {{ $poll->title }}
            </x-slot:title>

            @if(session()->has('error'))
                <x-ui.alert type="danger">
                    {{ session('error') }}
                </x-ui.alert>
            @endif
            <p>{{ __('pages/password.text') }}</p>
            <form action="{{ route('polls.checkPassword', $poll) }}" method="post">
                @csrf
                <div class="mb-3">
                    <x-ui.form.tw-input id="password"
                                        type="password"
                                        name="password"
                                        wire:model="password"
                    >
                        <x-slot:label>
                            {{ __('pages/password.labels.password') }}
                        </x-slot:label>
                    </x-ui.form.tw-input>
                </div>
                <button type="submit" class="tw-btn tw-btn-primary">{{ __('pages/password.buttons.submit') }}</button>
            </form>
        </x-ui.tw-card>

    </div>



</x-layouts.app>
