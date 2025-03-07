<div>
    <div class="modal-header bg-warning">
        <h5 class="modal-title">Share poll</h5>
        <button type="button" class="btn-close text-white" wire:click="$dispatch('hideModal')" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="link" class="form-label">Link</label>
            <div class="input-group">
                <input type="text" class="form-control" id="link" value="{{ $link }}" readonly>
                <button class="btn btn-outline-secondary" onclick="copyToClipboard(`{{ $link }}`)">Copy</button>
            </div>
    
        </div>
        <div class="mb-3">
            <label for="admin_key" class="form-label">Admin key</label>
            <div class="input-group">
                <input type="text" class="form-control" id="admin_key" value="{{$adminLink}}" readonly>
                <button class="btn btn-outline-secondary"onclick="copyToClipboard('{{ $adminLink }}')">Copy</button>
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
