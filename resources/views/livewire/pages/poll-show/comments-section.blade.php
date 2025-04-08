<x-ui.card body-padding="0" collapsable>
    <x-slot:header>
        {{ __('pages/poll-show.comments.title') }}
    </x-slot:header>

    @if ($poll->pollComments)
        <div wire:init="loadComments">
            @if($loadedComments)
                <div class="list-group">
                    @foreach ($poll->pollComments as $commentIndex => $comment)
                        <x-poll.show.comment-card :comment="$comment" wire:key="commentIndex"/>
                    @endforeach
                </div>
            @else

                <div class="d-flex justify-content-center">
                    <x-ui.spinner>
                        Loading comments...
                    </x-ui.spinner>
                </div>
            @endif



            <div class="p-3">

                {{-- Formulář pro přidání komentáře --}}
                <h3>{{ __('pages/poll-show.comments.form.title') }}</h3>
                <form wire:submit.prevent='addComment' wire:key='{{ now() }}'>

                    <x-ui.form.input id="username"
                                     wire:model="username"
                                     placeholder="{{ __('pages/poll-show.comments.form.username.placeholder') }}">
                        {{ __('pages/poll-show.comments.form.username.label') }}
                    </x-ui.form.input>
                    <x-ui.form.textbox id="content"
                                       wire:model="content"
                                       required
                                       placeholder="{{ __('pages/poll-show.comments.form.content.placeholder') }}">
                        {{ __('pages/poll-show.comments.form.content.label') }}
                    </x-ui.form.textbox>

                    <x-ui.button type="submit">
                        {{ __('pages/poll-show.comments.buttons.submit') }}
                    </x-ui.button>
                    <x-ui.saving wire:loading wire:target="addComment">
                        {{ __('pages/poll-show.comments.form.loading') }}
                    </x-ui.saving>
                    <x-ui.form.error-text error="error" />
                </form>
            </div>
        </div>
    @else

        <x-ui.alert type="warning">
            <x-ui.icon name="exclamation-triangle-fill"/>
            {{ __('pages/poll-show.comments.alert.disabled') }}
        </x-ui.alert>
    @endif


</x-ui.card>
