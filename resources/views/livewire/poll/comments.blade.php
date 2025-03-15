<x-card bodyPadding="0">

    <x-slot:header>
        Comments <span class="badge bg-secondary ms-1 fs-4">{{ $comments->count() }}</span>
    </x-slot:header>

    @if (!$poll->comments)
        <div class="alert alert-warning mb-0">
            <i class="bi bi-exclamation-triangle-fill"></i> Comments are disabled for this poll.
        </div>
    @else
    <div>

        <div class="list-group">

            @foreach ($comments as $comment)
                <x-poll.show.comment-card :comment="$comment" />
            @endforeach
        </div>


        <div class="p-3">

            {{-- Formulář pro přidání komentáře --}}
            <h3>Add new comments</h3>
            <form wire:submit.prevent='addComment' wire:key='{{ now() }}'>

                <x-input id="username" model="username" type="text">
                    Your name
                </x-input>
                <x-textbox id="content" model="content" mandatory="true">
                    Your message
                </x-textbox>

                <button type="submit" class="btn btn-primary btn-lg">Add comment</button>
            </form>
        </div>
    </div>
    @endif





</x-card>
