<div>
    <!-- MODAL HEADER -->
    <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title"><i class="bi bi-share"></i> Share Poll</h5>
        <button type="button" class="btn-close" wire:click="$dispatch('hideModal')" aria-label="Close"></button>
    </div>

    <!-- MODAL BODY -->
    <div class="modal-body">
        <!-- LINK -->
        <div class="mb-3">
            <label for="link" class="form-label">Link</label>
            <div class="mb-2">
                <small class="text-muted">
                    Share this link with participants so they can vote in the poll.
                </small>
            </div>

            <div class="input-group">
                <input type="text" class="form-control" id="link" value="{{ $link }}" readonly>
                <button class="btn btn-outline-primary" onclick="copyToClipboard('link')">
                    Copy
                </button>
            </div>
        </div>

        <div class="mb-3">
            <label for="admin_key" class="form-label">Admin Key</label>
            <div class="mb-2">
                <small class="text-muted"> This link is for administrators. It allows managing the poll and finalizing results.</small>
            </div>
            <div class="input-group">
                <input type="text" class="form-control" id="admin_key" value="{{ $adminLink }}" readonly>
                <button class="btn btn-outline-primary" onclick="copyToClipboard('admin_key')">
                    Copy
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Funkce pro kopírování odkazu do schránky
    function copyToClipboard($link) {

        navigator.clipboard.writeText($link);

    }
</script>
