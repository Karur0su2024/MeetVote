@props(['comment'])

@php

    // Zjistíme, zda je uživatel správce ankety nebo vlastníkem komentáře
    $canDelete = request()->get('isPollAdmin', false) || (!is_null($comment->user_id) && Auth::id() === $comment->user_id);

@endphp

<div class="card my-2 p-3">
    <div class="d-flex justify-content-between">
        <p>
            <span class="fw-bold">{{ $comment->user ? $comment->user->name : $comment->author_name }}</span>
            <span class="text-muted">{{ $comment->created_at->diffForHumans() }}</span>
        </p>

        {{-- V případě, že je uživatel správce nebo vlastník komentáře, tak může jej smazat --}}

        @can('delete', $comment)
            <x-ui.button color="outline-danger"
                         wire:click='deleteComment({{ $comment->id }})'>
                <i class="bi bi-trash"></i>

            </x-ui.button>
        @endcan
    </div>

    <p class="mb-0">
        {{ $comment->content }}
    </p>

</div>
