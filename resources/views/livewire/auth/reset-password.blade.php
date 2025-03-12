<div>
    <form wire:submit="resetPassword">

        {{-- Email --}}
        <x-input id="email" model="email" type="email" label="email" mandatory="true"  />


        {{-- Heslo --}}
        <x-input id="password" model="password" type="password" label="Password" mandatory="true"  />


        {{-- Potvrzení hesla --}}
        <x-input id="password_confirmation" model="password_confirmation" type="password" label="Confirm password" mandatory="true"  />


        <button class="btn btn-primary">
            Reset password
        </button>
    </form>
</div>


