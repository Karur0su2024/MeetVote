<div class="card text-start mb-3">
    <div class="card-header">
        <h3>Votes from others</h3>
    </div>
    <div class="card-body">
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
                    <tr>
                        <td>{{ $vote['voter_name'] }}</td>
                        <td>{{ $vote['updated_at'] }}</td>
                        <td><button class="btn btn-warning" wire:click='loadVote({{$vote['id']}})'>Edit vote</button></td>
                        <td><button class="btn btn-danger" wire:click='deleteVote({{$vote['id']}})'>Delete vote</button></td>
                    </tr>
                    t
                @endforeach
            </tbody>
        </table>
    </div>

</div>