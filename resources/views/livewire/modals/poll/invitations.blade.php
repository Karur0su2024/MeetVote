<div>
    <div class="modal-header">
        <h5 class="modal-title">Invitations</h5>
        <button type="button" class="btn-close" wire:click="$dispatch('hideModal')" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        @if($poll->status === 'active')
            @if (count($invitations) == 0)
                <div class="alert alert-secondary" role="alert">
                    No invitations added yet
                </div>
            @else
                <div class="table">
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
                                <td>
                                    {{ $invitation['status'] }}
                                </td>
                                <td>{{ $invitation['sent_at'] }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary"
                                            wire:click="resendInvitation({{ $invitation['id'] }})">
                                        <i class="bi bi-envelope"></i> Resend
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-danger"
                                            wire:click='removeInvitation({{ $invitation['id'] }})'>
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
                <form wire:submit.prevent="addInvitation" wire:key='{{ now() }}' class="mt-4">
                    <h3>Send new invitation</h3>
                    <x-ui.form.input id="email" wire:model="email" type="email" required placeholder="example@email.com">
                        E-mail
                    </x-ui.form.input>

                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <button type="submit" class="btn btn-primary btn-lg px-4 py-2 d-flex align-items-center">
                            Send invitation
                        </button>
                        <span wire:loading>
                    <div class="spinner-border spinner-border-sm me-2" role="status">
                    </div>
                    Processing...
                </span>

                        @if (session()->has('error'))
                            <div class="text-danger ms-2">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session()->has('success'))
                            <div class="text-success ms-2">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                </form>
        @else

            <x-ui.alert type="danger">
                This poll is closed. You can't send invitations.
            </x-ui.alert>
        @endif




    </div>
</div>
