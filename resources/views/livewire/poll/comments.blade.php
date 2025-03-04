<div class="card text-start mb-3">
    <div class="card-header py-3">
        <h2>Comments</h2>
    </div>
    <div class="card-body p-0">
        <div class="list-group">

            @foreach ($comments as $comment)
                <x-poll.show.comment-card :comment="$comment" />
            @endforeach
        </div>
        <div class="p-3">
            <h3>Add new comments</h3>
            <form wire:submit.prevent='addComment'>
                <div class="mb-3">
                    <label for="content">Your name</label>
                    <input type="text" id="content" class="form-control" wire:model="username">
                    @error('username')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="content">Content</label>
                    <textarea id="content" class="form-control" wire:model="content"></textarea>
                    @error('content')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Add comment</button>
            </form>
        </h2>

        </div>


    </div>
</div>