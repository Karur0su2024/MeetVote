<div class="mb-3">

    <label for="{{ $id ?? '' }}" class="form-label">
        {{ $slot }}
        <x-ui.red-text>
            {{ $attributes->has('required') ? '*' : '' }}
        </x-ui.red-text>

        @if ($tooltip ?? null)
            <small class="ms-2">
                <x-ui.tooltip :tooltip="$tooltip" />
            </small>
        @endif
    </label>


    <textarea
        {{ $attributes }}
        class="form-control {{ $dataClass ?? '' }} "
        rows="5"
        aria-label="{{ $slot }}"
        aria-required="{{ $attributes->has('required') ? 'true' : 'false' }}">
    </textarea>

    @if($error ?? null)
        @error($error)
            <x-ui.red-text>
                {{ $message }}
            </x-ui.red-text>
        @enderror
    @endif
</div>
