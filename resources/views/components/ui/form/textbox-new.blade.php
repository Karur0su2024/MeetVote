<div class="fieldset flex flex-col">
    <label for="{{ $id ?? '' }}" class="fieldset-legend flex items-center gap-2">
        {{ $slot }}
        @if ($tooltip ?? null)
            <div class="tooltip ml-1" data-tip="{{ $tooltip }}">
                <i class="bi bi-info-circle"></i>
            </div>
        @endif
    </label>
    <textarea {{ $attributes }}
              class="textarea w-full {{ $dataClass ?? '' }}"
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
