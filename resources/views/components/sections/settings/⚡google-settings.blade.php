<?php

use Livewire\Component;

new class extends Component
{
    public $user;

    public function mount()
    {
        $this->user = auth()->user();
    }
};
?>

<div class="mt-3">
    <div class="flex">
        {{--        @if ($user->google_id)

                    <p class="text-muted">
                        {{ __('pages/user-settings.google.connected.text') }}
                    </p>

                    <a href="{{ route('google.oauth.disconnect') }}" class="btn btn-outline btn-error my-3">
                        <i class="bi bi-google"></i> {{ __('pages/user-settings.google.buttons.disconnect') }}
                    </a>

                    @if($user->calendar_access)
                        <p class="text-muted">
                            {{ __('pages/user-settings.google.text.synced_events', ['synced_events_count' => $user->syncedEvents->count()]) }}
                        </p>
                        <a href="{{ route('google.calendar.disconnect') }}" class="btn btn-outline btn-error my-3">
                            <i class="bi bi-google"></i> {{ __('pages/user-settings.google.buttons.disconnect_calendar') }}
                        </a>
                    @else
                        <a href="{{ route('google.calendar.login') }}" class="btn btn-outline btn-primary my-3">
                            <i class="bi bi-google"></i> {{ __('pages/user-settings.google.buttons.connect_calendar') }}
                        </a>
                    @endif

                @else
                    <a href="{{ route('google.oath.login') }}" class="btn btn-outline-primary">
                        <i class="bi bi-google"></i> {{ __('pages/user-settings.google.buttons.connect') }}
                    </a>
                @endif--}}

        <div class="tooltip" data-tip="This feature is deprecated and will be reimplemented in the future.">
            <button class="btn btn-disabled">
                <i class="bi bi-google"></i>
                {{ __('pages/user-settings.google.buttons.connect') }}
            </button>
        </div>

    </div>


    @if (session()->has('settings.google.success'))
        <span class="text-success ms-3">{{ session('settings.google.success') }}</span>
    @endif
    @if (session()->has('settings.google.error'))
        <span class="text-danger ms-3">{{ session('settings.google.error') }}</span>
    @endif
</div>
