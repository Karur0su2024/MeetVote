<div>

    <h4 class="text-md font-semibold mb-2">
        {{ __('pages/poll-editor.basic_info.section.user') }}
    </h4>

    {{-- Jméno autora --}}
    <x-mary-input label="{{ __('pages/poll-editor.basic_info.user_name.label') }}"
                  wire:model="form.user.name"
                  required
                  placeholder="{{ __('pages/poll-editor.basic_info.user_name.placeholder') }}" />


    {{-- E-mail autora --}}
    <x-mary-input label="{{ __('pages/poll-editor.basic_info.user_email.label') }}"
                  wire:model="form.user.email"
                  type="email"
                  required
                  placeholder="{{ __('pages/poll-editor.basic_info.user_email.placeholder') }}" />
</div>
