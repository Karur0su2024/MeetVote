<fieldset class="tw:fieldset tw:mb-3">
    <span class="tw:fieldset-legend tw:pb-1">
        {{ $slot }}
        @if ($tooltip ?? null)
            <small class="tw:ms-2">
                <x-ui.tooltip :tooltip="$tooltip"/>
            </small>
        @endif
    </span>
    <textarea {{ $attributes }}
              aria-label="{{ $slot }}"
              aria-required="{{ $attributes->has('required') ? 'true' : 'false' }}"
              class="tw:textarea tw:h-24 tw:w-full">

    </textarea>
    @if($error ?? null)
        @error($error)
        <span class="tw:text-danger tw:pt-3">">
            {{ $message }}
        </span>

        @enderror
    @endif

</fieldset>
