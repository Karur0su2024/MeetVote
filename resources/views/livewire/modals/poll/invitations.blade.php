<div>
    <div class="modal-header bg-warning">
        <h5 class="modal-title">Invitations</h5>
        <button type="button" class="btn-close text-white" wire:click="$dispatch('hideModal')" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        @if (count($invitations) == 0)
            <div class="alert alert-secondary" role="alert">
                No invitations added
            </div>
        @else
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
        @endif


        <form wire:submit.prevent="addInvitation" wire:key='{{ now() }}' class="mt-4">
            <h3>Send new invitation</h3>
            <x-input id="email" model="email" type="email" mandatory="true" placeholder="example@email.com">
                E-mail
            </x-input>

            <button class="btn btn-primary" type="submit">Send</button>
        </form>
    </div>
</div>
