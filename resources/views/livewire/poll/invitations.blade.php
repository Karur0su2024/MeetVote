<div class="card text-start mb-3">
    <div class="card-header">
        <h2>Invitations</h2>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>E-mail</th>
                    <th>Status</th>
                    <th>Sent at</th>
                    <th>Send again</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invitations as $invitation)
                    <tr>
                        <td>{{ $invitation['email'] }}</td>
                        <td>{{ $invitation['status'] }}</td>
                        <td>{{ $invitation['sent_at'] }}</td>
                        <td><button class="btn btn-outline-secondary">Send again</button></td>
                        <td><button class="btn btn-danger">Remove</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <form wire:submit.prevent="addInvitation">
            <x-input id="email" model="email" type="email" label="Email" />

            <button class="btn btn-primary" type="submit">Odeslat pozvánky</button>
        </form>
    </div>
</div>

@livewireScripts
