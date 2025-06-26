{{-- Sekce s komentáři --}}
<div class="card bg-base-100 p-3">
    <h3 class="text-lg">
        {{ __('pages/poll-show.comments.form.title') }}
    </h3>

    <form class="mt-3" wire:submit.prevent='addComment' wire:key='{{ now() }}'>

        @guest
            <x-ui.form.input-new id="username"
                                 wire:model="username"
                                 required
                                 placeholder="{{ __('pages/poll-show.comments.form.username.placeholder') }}">
                {{ __('pages/poll-show.comments.form.username.label') }}
            </x-ui.form.input-new>
        @endguest

        <x-ui.form.textbox-new id="content"
                               wire:model="content"
                               required
                               placeholder="{{ __('pages/poll-show.comments.form.content.placeholder') }}">
            {{ __('pages/poll-show.comments.form.content.label') }}
        </x-ui.form.textbox-new>

        <button class="btn btn-primary btn-sm mt-2" type="submit">
            {{ __('pages/poll-show.comments.buttons.submit') }}
        </button>

        <x-ui.saving wire:loading wire:target="addComment">
            {{ __('pages/poll-show.comments.form.loading') }}
        </x-ui.saving>
        <x-ui.form.error-text error="error"/>
    </form>


    @if ($poll->pollComments)
        <div wire:init="loadComments">
            @else
                <x-ui.alert type="warning">
                    <x-ui.icon name="exclamation-triangle-fill"/>
                    {{ __('pages/poll-show.comments.alert.disabled') }}
                </x-ui.alert>
            @endif
            <div>

                @if($loadedComments)

                    @foreach ($poll->pollComments as $commentIndex => $comment)
                        <x-pages.poll-show.comment-card :comment="$comment" wire:key="commentIndex"/>
                    @endforeach
                @else

                    <div class="text-center py-2">
                        <x-ui.spinner>
                            Loading comments...
                        </x-ui.spinner>
                    </div>

                @endif
            </div>
        </div>

</div>
