{{-- Modální okno s správcem pozvánek --}}
<div>
    <x-ui.modal.header>
        {{ __('ui/modals.invitations.title') }}
    </x-ui.modal.header>
    <div class="modal-body">
        @if($poll->isActive())
            @if (count($poll->invitations) === 0)
                <div class="alert alert-secondary" role="alert">
                    {{ __('ui/modals.invitations.alerts.info.no_invitations') }}
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
            <form wire:submit.prevent="addInvitations" wire:key='{{ now() }}' class="mt-4">
                <h3>{{ __('ui/modals.invitations.text') }}</h3>

                    <x-ui.form.textbox
                    id="emails"
                    wire:model="emails"
                    placeholder="{{ __('ui/modals.invitations.emails.placeholder') }}">
                    {{ __('ui/modals.invitations.emails.label') }}
                    </x-ui.form.textbox>

                <x-ui.button type="submit">
                    {{ __('ui/modals.invitations.buttons.send') }}
                </x-ui.button>
                <x-ui.saving wire:loading>
                    {{ __('ui/modals.invitations.loading') }}
                </x-ui.saving>
                <x-ui.form.error-text error="error" />
            </form>
        @else
            <x-ui.alert type="danger">
                <x-ui.icon class="exclamation-triangle"/>
                {{ __('ui/modals.invitations.alerts.error.closed') }}
            </x-ui.alert>
        @endif
    </div>
</div>
