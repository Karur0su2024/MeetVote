@props([
    'username' => null,
    'avatar' => null,
])


<div class="tw-flex tw-items-center tw-gap-2">
    @auth
        <div class="tw-avatar tw-avatar-placeholder">
            <div class="tw-w-6 tw-rounded-full tw-bg-neutral tw-text-neutral-content tw-flex tw-items-center tw-justify-center">
            <span class="tw-text-sm">
                {{ mb_substr(Auth::user()->name, 0, 1) }}
            </span>
            </div>
        </div>
    @endauth
    <span class="tw-text-sm">
        {{ $username ?? '' }}
    </span>
</div>
