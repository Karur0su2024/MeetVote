<div>
    <div class="modal-header bg-warning">
        <h5 class="modal-title">Results</h5>
        <button type="button" class="btn-close text-white" wire:click="$dispatch('hideModal')" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <table class="table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Last change</th>

                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($votes as $vote)
                    <x-poll.show.vote-card :vote="$vote" />
                @endforeach
            </tbody>
        </table>
    </div>
</div>
