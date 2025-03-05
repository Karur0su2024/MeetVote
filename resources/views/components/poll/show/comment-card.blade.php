@props(['comment'])

@php

// Zjistíme, zda je uživatel správce ankety nebo vlastníkem komentáře
$canDelete = session()->has('isPollAdmin', false) || (!is_null($comment->user_id) && (Auth::id() === $comment->user_id));


@endphp

<div class="list-group-item p-3">
    <div class="d-flex justify-content-between">
        <p>
            <span class="fw-bold">{{ $comment->author_name }}</span>
            <span class="text-muted">{{ $comment->created_at->diffForHumans() }}</span>
        </p>

        {{-- V případě, že je uživatel správce nebo vlastník komentáře, tak může jej smazat --}}
        @if ($canDelete)
            <button class="btn btn-outline-secondary" wire:click='deleteComment({{$comment->id}})'>Delete </button>
        @endif


    </div>

    <p>
        {{ $comment->content }}
    </p>

</div>
