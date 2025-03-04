<div class="card">
    <div class="card-header">
        <h2>User settings</h2>
    </div>
    <div class="card-body text-start">
        <form wire:submit.prevent='updateProfile'>
            <h3>User info</h3>
            <div class="mb-3">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" wire:model="name">
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" id="email" class="form-control" wire:model="email">
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>

    </div>
    
</div>