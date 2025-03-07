@props(['comment'])

@php

    // Zjistíme, zda je uživatel správce ankety nebo vlastníkem komentáře
    $canDelete = request()->get('isPollAdmin', false) || (!is_null($comment->user_id) && Auth::id() === $comment->user_id);

@endphp

<div class="list-group-item card-sharp p-3">
    @if ($comment->deleted_at)
        <div class="d-flex justify-content-between">
            <span class="badge bg-danger">Deleted</span>
        </div>
    @else
        <div class="d-flex justify-content-between">
            <p>
                <span class="fw-bold">{{ $comment->author_name }}</span>
                <span class="text-muted">{{ $comment->created_at->diffForHumans() }}</span>
            </p>

            {{-- V případě, že je uživatel správce nebo vlastník komentáře, tak může jej smazat --}}
            @if ($canDelete)
                <button class="btn btn-outline-secondary" wire:click='deleteComment({{ $comment->id }})'>Delete </button>
            @endif

        </div>
    @endif


    <p>
        {{ $comment->content }}
    </p>

</div>
