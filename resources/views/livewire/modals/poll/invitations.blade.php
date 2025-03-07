<div>
    <div class="modal-header bg-warning">
        <h5 class="modal-title">Invitations</h5>
        <button type="button" class="btn-close text-white" wire:click="$dispatch('hideModal')" aria-label="Close"></button>
    </div>
    <div class="modal-body">
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
                        <td><button class="btn btn-danger"
                                wire:click='removeInvitation({{ $invitation['id'] }})'>Remove</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <form wire:submit.prevent="addInvitation" wire:key='{{ now() }}'>
            <x-input id="email" model="email" type="email" label="Email" />

            <button class="btn btn-primary" type="submit">Odeslat pozvánky</button>
        </form>
    </div>
</div>
