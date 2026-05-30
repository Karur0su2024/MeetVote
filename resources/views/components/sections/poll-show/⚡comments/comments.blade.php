{{-- Sekce s komentáři --}}
{{-- Sekce s komentáři --}}
<x-ui.card>
    <div class="flex flex-col gap-3">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <x-ui.text.title-w-icon>
                <x-slot:icon>
                    <x-mary-icon name="o-chat-bubble-left-right" class="text-xl"/>
                </x-slot:icon>
                <x-slot:title>
                    {{ __('pages/poll-show.comments.form.title') }}
                </x-slot:title>
                <x-slot:subtitle>
                    @if ($poll->pollComments)
                        {{ $poll->pollComments->count() }} comments
                    @else
                        {{ __('pages/poll-show.comments.alert.disabled') }}
                    @endif
                </x-slot:subtitle>
            </x-ui.text.title-w-icon>
        </div>

        @if ($poll->pollComments)
            <div wire:init="loadComments">
                {{-- Formulář pro přidání komentáře --}}
                <form wire:submit.prevent="addComment"
                      wire:key="{{ now() }}">
                    <div class="flex flex-col gap-4">
                        @guest

                            <x-mary-input label="{{ __('pages/poll-show.comments.form.username.label') }}"
                                          id="username"
                                          wire:model="username"
                                          required
                                          placeholder="{{ __('pages/poll-show.comments.form.username.placeholder') }}">
                            </x-mary-input>
                        @endguest


                        <x-mary-textarea label="{{ __('pages/poll-show.comments.form.content.label') }}"
                                         wire:model="content"
                                         id="content"
                                         required
                                         placeholder="{{ __('pages/poll-show.comments.form.content.placeholder') }}"
                        />

                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <button class="btn btn-primary btn-sm"
                                    type="submit"
                                    wire:loading.attr="disabled"
                                    wire:target="addComment">
                                <span wire:loading.remove wire:target="addComment"
                                      class="inline-flex items-center gap-2">
                                    <i class="bi bi-send"></i>
                                    {{ __('pages/poll-show.comments.buttons.submit') }}
                                </span>

                                <span wire:loading wire:target="addComment" class="inline-flex items-center gap-2">
                                    <span class="loading loading-spinner loading-xs"></span>
                                    {{ __('pages/poll-show.comments.form.loading') }}
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @else
            <div class="rounded-2xl border border-warning/30 bg-warning/10 p-4 text-warning-content">
                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-warning/20">
                        <x-ui.icon name="exclamation-triangle-fill"/>
                    </div>

                    <div>
                        <p class="font-medium">
                            {{ __('pages/poll-show.comments.alert.disabled') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div>
            @if ($loadedComments)
                @if ($poll->pollComments->isNotEmpty())
                    <div class="flex flex-col gap-3">
                        @foreach ($poll->pollComments as $commentIndex => $comment)
                            <x-ui.comment-card :comment="$comment" wire:key="comment-{{ $comment->id }}"/>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-2xl border border-dashed border-base-300 bg-base-100 px-6 py-10 text-center">
                        <div
                            class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-base-200 text-base-content/50">
                            <x-mary-icon name="o-chat-bubble-left" class="text-2xl"/>
                        </div>

                        <p class="font-medium">
                            No comments yet
                        </p>

                        <p class="mt-1 text-sm text-base-content/60">
                            Be the first one to join the discussion.
                        </p>
                    </div>
                @endif
            @else
                <div class="rounded-2xl border border-base-300 bg-base-100 px-6 py-8 text-center">
                    <span class="loading loading-spinner loading-md text-primary"></span>

                    <p class="mt-3 text-sm text-base-content/60">
                        Loading comments...
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-ui.card>