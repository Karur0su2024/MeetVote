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
                    <x-poll.show.vote-card :vote="$vote" />
                @endforeach
            </tbody>
        </table>
    </div>

</div>