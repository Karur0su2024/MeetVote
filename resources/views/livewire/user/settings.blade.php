<div>


    <div class="card text-start mb-3">
        <div class="card-header py-3">
            <h2>Profile information</h2>
        </div>
        <div class="card-body">
            <form wire:submit.prevent='updateProfile'>

                <div class="mb-3">
                    <label for="name">Name</label>
                    <input type="text" id="name" class="form-control" wire:model="name">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" id="email" class="form-control" wire:model="email">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>

        </div>

    </div>

    <div class="card text-start mb-3">
        <div class="card-header py-3">
            <h2>Password</h2>
        </div>
        <div class="card-body">
            <form wire:submit.prevent='updatePassword'>                
                <div class="mb-3">
                    <label for="current_password">Current password</label>
                    <input type="password" id="current_password" class="form-control" wire:model="current_password">
                    @error('current_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password">New password</label>
                    <input type="password" id="password" class="form-control" wire:model="new_password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation">Confirm new password</label>
                    <input type="password" id="password_confirmation" class="form-control" wire:model="password_confirmation">
                    @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
            
        </div>

    </div>

    <div class="card text-start mb-3">
        <div class="card-header py-3">
            <h2>Preferences</h2>
        </div>
        <div class="card-body">
            To be added

        </div>

    </div>

    <div class="card text-start mb-3">
        <div class="card-header py-3">
            <h2>Google & Calendar</h2>
        </div>
        <div class="card-body">
            To be added

        </div>

    </div>

    <div class="card text-start">
        <div class="card-header py-3">
            <h2>Delete account</h2>
        </div>
        <div class="card-body">
            
            <button class="btn btn-danger" wire:click="deleteAccount">
                Delete account
            </button>

        </div>

    </div>
</div>
