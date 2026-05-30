@props([
    'username' => null,
    'avatar' => null,
])


<div class="flex items-center gap-2">
    @auth
        <div class="avatar avatar-placeholder">
            <div class="w-6 rounded-full bg-purple-600 text-neutral-content flex items-center justify-center">
            <span class="text-sm">
                {{ mb_substr(Auth::user()->name, 0, 1) }}
            </span>
            </div>
        </div>
    @endauth
    <span class="text-sm">
        {{ $username ?? '' }}
    </span>
</div>
