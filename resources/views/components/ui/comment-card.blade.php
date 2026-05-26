@props(['comment'])

@php

    // Zjistíme, zda je uživatel správce ankety nebo vlastníkem komentáře
    $canDelete = request()->get('isPollAdmin', false) || (!is_null($comment->user_id) && Auth::id() === $comment->user_id);

@endphp

<div class="chat chat-start">
    <div class="chat-header">
        {{ $comment->user ? $comment->user->name : $comment->author_name }}
        <time class="text-xs opacity-50">{{ $comment->created_at->diffForHumans() }}</time>

    </div>
    <div class="chat-image avatar avatar-placeholder">
        <div class="w-10 rounded-full bg-purple-600 text-neutral-content flex items-center justify-center">
            <span class="text-sm">
                {{ mb_substr($comment->user ? $comment->user->name : $comment->author_name, 0, 1) }}
            </span>
        </div>
    </div>
    <div class="chat-bubble break-all">{{ $comment->content }}</div>
    <div class="chat-footer mt-1 ">
        @can('delete', $comment)
            <button class="text-gray-600/75 cursor-pointer"
                    wire:click='deleteComment({{ $comment->id }})'>
                Delete
            </button>
        @endcan
    </div>
</div>

