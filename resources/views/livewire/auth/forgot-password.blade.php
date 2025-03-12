<div class="container d-flex justify-content-center align-items-center text-start pt-5">
    <div class="col-md-6">
        <div class="card shadow p-4">
            <h2 class="text-center mb-4">Forgot Password</h2>

            <form class="mt-3 text-start" wire:submit="sendPasswordResetLink">

                <!-- Email -->
                <x-input id="email" model="email" type="email" label="Email" required>
                    Email
                </x-input>


                <button class="btn btn-primary">Send password reset link</button>

            </form>
        </div>
    </div>
</div>
