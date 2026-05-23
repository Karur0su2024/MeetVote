@props(['comment'])

@php

    // Zjistíme, zda je uživatel správce ankety nebo vlastníkem komentáře
    $canDelete = request()->get('isPollAdmin', false) || (!is_null($comment->user_id) && Auth::id() === $comment->user_id);

@endphp

{{--<div class="tw:card tw:my-2 tw:p-3 tw:border-dashed tw:border tw:border-gray-500/75">--}}
{{--    <div class="tw:flex tw:items-center">--}}
{{--        <p class="tw:flex tw:gap-2">--}}
{{--            <span class="tw:font-semibold">{{ $comment->user ? $comment->user->name : $comment->author_name }}</span>--}}
{{--            <span class="tw:font-base-content tw:font-light">{{ $comment->created_at->diffForHumans() }}</span>--}}
{{--        </p>--}}

{{--        --}}{{-- V případě, že je uživatel správce nebo vlastník komentáře, tak může jej smazat --}}

{{--        @can('delete', $comment)--}}
{{--            <button class="tw:btn tw:btn-outline tw:btn-error tw:btn-sm"--}}
{{--                    wire:click='deleteComment({{ $comment->id }})'>--}}
{{--                <i class="bi bi-trash"></i>--}}

{{--            </button>--}}
{{--        @endcan--}}
{{--    </div>--}}

{{--    <p class="tw:font-light tw:text-sm tw:text-balance tw:break-all">--}}
{{--        {{ $comment->content }}--}}
{{--    </p>--}}

{{--</div>--}}

<div class="tw:chat tw:chat-start">
    <div class="tw:chat-header">
        {{ $comment->user ? $comment->user->name : $comment->author_name }}
        <time class="text-xs opacity-50">{{ $comment->created_at->diffForHumans() }}</time>
    </div>
    <div class="tw:chat-image tw:avatar tw:avatar-placeholder">
        <div class="tw:w-10 tw:rounded-full tw:bg-purple-600 tw:text-neutral-content tw:flex tw:items-center tw:justify-center">
            <span class="tw:text-sm">
                {{ mb_substr($comment->user ? $comment->user->name : $comment->author_name, 0, 1) }}
            </span>
        </div>
    </div>
    <div class="tw:chat-bubble tw:break-all">{{ $comment->content }}</div>
</div>

