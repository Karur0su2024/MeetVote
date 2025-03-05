<div class="card mb-3">
    <div class="card-header">
        <h2>Share</h2>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="link" class="form-label">Link</label>
            <div class="d-flex ">
                <input type="text" class="form-control" id="link" value="{{ route('polls.show', $poll) }}" readonly>
                <button class="btn btn-outline-secondary" onclick="copyToClipboard(`{{ route('polls.show', $poll) }}`)">Copy</button>
            </div>

        </div>
        <div class="mb-3">
            <label for="admin_key" class="form-label">Admin key</label>
            <div class="d-flex">
                <input type="text" class="form-control" id="admin_key" value="{{ route('polls.show', $poll) }}/{{ $poll->admin_key }}" readonly>
                <button class="btn btn-outline-secondary"onclick="copyToClipboard(`{{ route('polls.show', $poll) }}/{{ $poll->admin_key }}`)">Copy</button>
            </div>
        </div>
    </div>
</div>

<script>

function copyToClipboard($link){
    
    navigator.clipboard.writeText($link);

    alert($link);

}


</script>