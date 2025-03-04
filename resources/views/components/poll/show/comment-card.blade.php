@props(['comment'])

<div class="list-group-item p-3">
    <span class="fw-bold">{{ $comment->author_name }}</span>
    <p>
        {{ $comment->content }}
    </p>

</div>
