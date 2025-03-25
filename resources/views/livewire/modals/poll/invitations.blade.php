<div>
    <x-ui.modal.header>
        {{ __('ui/modals.invitations.title') }}
    </x-ui.modal.header>
    <div class="modal-body">
        @if($poll->isActive())
            @if (count($poll->invitations) === 0)
                <div class="alert alert-secondary" role="alert">
                    No invitations added yet
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{ __('ui/modals.invitations.table.headers.email') }}</th>
                            <th>{{ __('ui/modals.invitations.table.headers.status') }}</th>
                            <th>{{ __('ui/modals.invitations.table.headers.sent_at') }}</th>
                            <th>{{ __('ui/modals.invitations.table.headers.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($poll->invitations as $invitation)
                            <tr>
                                <td>{{ $invitation['email'] }}</td>
                                <td>
                                    {{ $invitation['status'] }}
                                </td>
                                <td>{{ $invitation['sent_at'] }}</td>
                                <td class="d-flex gap-2">
                                    <x-ui.button color="outline-primary"
                                                 size="sm"
                                                 wire:click="resendInvitation({{ $invitation['id'] }})">
                                        <x-ui.icon class="envelope"/>
                                        {{ __('ui/modals.invitations.table.actions.resend') }}
                                    </x-ui.button>
                                    <x-ui.button color="outline-danger"
                                                 size="sm"
                                                 wire:click="removeInvitation({{ $invitation['id'] }})">
                                        <x-ui.icon class="trash"/>
                                        {{ __('ui/modals.invitations.table.actions.delete') }}
                                    </x-ui.button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            <form wire:submit.prevent="addInvitation" wire:key='{{ now() }}' class="mt-4">
                <h3>{{ __('ui/modals.invitations.text') }}</h3>

                <x-ui.form.input id="email"
                                 wire:model="email"
                                 type="email"
                                 required
                                 placeholder="example@email.com">
                    {{ __('ui/modals.invitations.email.label') }}
                    <x-slot:input-group>
                        <x-ui.button type="submit">
                            {{ __('ui/modals.invitations.buttons.send') }}
                        </x-ui.button>
                    </x-slot:input-group>
                </x-ui.form.input>

                <div>
                    <x-ui.saving wire:loading>
                        {{ __('ui/modals.invitations.loading') }}
                    </x-ui.saving>
                    @if (session()->has('error'))
                        <x-ui.red-text>
                            {{ session('error') }}
                        </x-ui.red-text>
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
                <x-ui.icon class="exclamation-triangle"/>
                {{ __('ui/modals.invitations.alerts.error.closed') }}
            </x-ui.alert>
        @endif
    </div>
</div>
