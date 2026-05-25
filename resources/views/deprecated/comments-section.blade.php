{{-- Sekce s komentáři --}}
<x-ui.tw-card body-padding="0" header-hidden>
    <x-slot:title>
        {{ __('pages/poll-show.comments.form.title') }}
    </x-slot:title>
    @if ($poll->pollComments)
        <div wire:init="loadComments">

            <div>
                {{-- Formulář pro přidání komentáře --}}
                <form class="mb-3" wire:submit.prevent='addComment' wire:key='{{ now() }}'>

                    @guest
                        <x-ui.form.tw-input id="username"
                                            wire:model="username"
                                            required
                                            placeholder="{{ __('pages/poll-show.comments.form.username.placeholder') }}">
                            {{ __('pages/poll-show.comments.form.username.label') }}
                        </x-ui.form.tw-input>
                    @endguest

                    <x-ui.form.tw-textbox id="content"
                                          wire:model="content"
                                          required
                                          placeholder="{{ __('pages/poll-show.comments.form.content.placeholder') }}">
                        {{ __('pages/poll-show.comments.form.content.label') }}
                    </x-ui.form.tw-textbox>
                    <button class="btn btn-sm btn-primary"
                            type="submit"
                    >
                        {{ __('pages/poll-show.comments.buttons.submit') }}
                    </button>

                    <x-ui.saving wire:loading wire:target="addComment">
                        {{ __('pages/poll-show.comments.form.loading') }}
                    </x-ui.saving>
                    <x-ui.form.error-text error="error"/>
                </form>
            </div>
        </div>
    @else

        <x-ui.alert type="warning">
            <x-ui.icon name="exclamation-triangle-fill"/>
            {{ __('pages/poll-show.comments.alert.disabled') }}
        </x-ui.alert>
    @endif

    <div>

        @if($loadedComments)
            <div class="flex flex-col gap-3">
                @foreach ($poll->pollComments as $commentIndex => $comment)
                    <x-pages.poll-show.comment-card :comment="$comment" wire:key="commentIndex"/>
                @endforeach
            </div>
        @else

            <div class="text-center py-2">
                <span class="loading loading-spinner me-2"></span>Loading comments...
            </div>

        @endif
    </div>


</x-ui.tw-card>
