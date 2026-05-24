<fieldset class="fieldset">
    <span class="fieldset-legend pb-1">
        {{ $slot }}
        @if ($tooltip ?? null)
            <small class="ms-2">
                <x-ui.tooltip :tooltip="$tooltip"/>
            </small>
        @endif
    </span>
    <textarea {{ $attributes }}
              aria-label="{{ $slot }}"
              aria-required="{{ $attributes->has('required') ? 'true' : 'false' }}"
              class="textarea h-24 w-full">

    </textarea>
    @if($error ?? null)
        @error($error)
        <span class="text-danger pt-3">">
            {{ $message }}
        </span>

        @enderror
    @endif

</fieldset>
