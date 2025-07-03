<fieldset class="tw-fieldset mb-3">
    <span class="tw-fieldset-legend py-0">
        {{ $slot }}
        @if ($tooltip ?? null)
            <small class="ms-2">
                <x-ui.tooltip :tooltip="$tooltip" />
            </small>
        @endif
    </span>
    <textarea {{ $attributes }}
              aria-label="{{ $slot }}"
              aria-required="{{ $attributes->has('required') ? 'true' : 'false' }}"
              class="tw-textarea tw-h-24 w-100">

    </textarea>
    @if($error ?? null)
        @error($error)
        <x-ui.red-text>
            {{ $message }}
        </x-ui.red-text>
        @enderror
    @endif

</fieldset>
