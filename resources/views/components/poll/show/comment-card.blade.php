@props(['comment'])

<div class="list-group-item p-3">
    <div class="d-flex justify-content-between">
        <p>
            <span class="fw-bold">{{ $comment->author_name }}</span>
            <span class="text-muted">{{ $comment->created_at->diffForHumans() }}</span>
        </p>
        <button class="btn btn-outline-secondary" wire:click='deleteComment({{$comment->id}})'>Delete </button>

    </div>

    <p>
        {{ $comment->content }}
    </p>

</div>
