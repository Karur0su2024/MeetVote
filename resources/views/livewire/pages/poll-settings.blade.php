<form class="container" wire:submit="savePollSettings">
    <x-card col="8" class="p-3">
        <h4 class="mb-3">{{ __('Basic information') }}</h4>

        {{-- Název ankety --}}
        <x-form.text-input type="text" name="form.title" id="title" label="Title" model="form.title" />


        {{-- Popisek ankety --}}
        <div class="mb-3">
            <label class="form-label mb-1" for="description"> {{ __('Description') }}</label>
            <textarea class="form-control" name="description" id="description" rows="5" wire:model='form.description'></textarea>
            @error('form.description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <x-form.text-input type="text" name="form.username" id="username" label="{{ __('Your name') }}"
            model="form.username" />
        <x-form.text-input type="email" name="form.email" id="email" label="{{ __('E-mail') }}"
            model="form.email" />

    </x-card>

    <div class="text-center mx-auto">
        <x-button type="submit" style="primary" size="md" class="w-50 mt-5">{{ __('Submit') }}</x-button>
    </div>
</form>
