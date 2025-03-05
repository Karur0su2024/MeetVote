@props(['poll'])

@php

$link = route('polls.show', $poll);
$admin_link = route('polls.show', $poll) . '/' . $poll->admin_key;

@endphp

<div class="card mb-3">
    <div class="card-header">
        <h2>Share</h2>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="link" class="form-label">Link</label>
            <div class="d-flex ">
                <input type="text" class="form-control" id="link" value="{{ $link }}" readonly>
                <button class="btn btn-outline-secondary" onclick="copyToClipboard(`{{ $link }}`)">Copy</button>
            </div>

        </div>
        <div class="mb-3">
            <label for="admin_key" class="form-label">Admin key</label>
            <div class="d-flex">
                <input type="text" class="form-control" id="admin_key" value="{{ route('polls.show', $poll) }}/{{ $poll->admin_key }}" readonly>
                <button class="btn btn-outline-secondary"onclick="copyToClipboard(`{{ $admin_link }}`)">Copy</button>
            </div>
        </div>
    </div>
</div>

<script>

// Funkce pro kopírování odkazu do schránky
function copyToClipboard($link){
    
    navigator.clipboard.writeText($link);

}


</script>