<div class="container d-flex justify-content-center align-items-center text-start pt-5">
    <div class="col-md-6">
        <div class="card shadow p-4">
            <h2 class="text-center mb-4">Reset Password</h2>


            <p class="text-muted">
                Please enter your new password.
            </p>

            <form wire:submit="resetPassword">


                {{-- Heslo --}}
                <x-input id="password" model="password" type="password" label="Password" required>
                    Password
                </x-input>


                {{-- Potvrzení hesla --}}
                <x-input id="password_confirmation" model="password_confirmation" type="password" required>
                    Confirm password
                </x-input>


                <button class="btn btn-primary">
                    Reset password
                </button>
            </form>
        </div>
    </div>
</div>
