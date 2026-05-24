<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div>
    {{-- The only way to do great work is to love what you do. - Steve Jobs --}}

    <div class="card mb-3 p-2 shadow-sm bg-base-100 col-span-2">
        <div class="flex justify--between items-center">
            <div>
                @if($poll)
                    <a class="btn btn-soft text-left" href="{{ route('polls.show', $poll) }}">
                        {{ __('pages/poll-editor.button.return') }}
                    </a>
                @endif
            </div>
            <div class="flex gap-2 grow flex-row-reverse items-center">

                <button class="btn btn-primary"
                        type="submit">
                    {{ __('pages/poll-editor.button.submit') }}
                </button>
                @error('error')
                <span class="text-error">
                    {{ $message }}
                </span>
                @enderror

                @if ($errors->any())
                    <span class="text-error">
                        {{ __('pages/poll-editor.messages.error.general') }}
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>
