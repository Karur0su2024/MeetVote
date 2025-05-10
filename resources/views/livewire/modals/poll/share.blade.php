{{-- Modální okno s odkazy pro sdílení --}}
<div>
    <div x-data="() => {
        return {
        // Alpine.js pro zkopírování URL adresy
                link: false,
                admin_link: false,
                copyToClipboard(id) {
                    if(id == 'link') {
                        this.admin_link = false;
                        this.link = true;
                    } else {
                        this.link = false;
                        this.admin_link = true;
                    }
                    input = document.getElementById(id);
                    navigator.clipboard.writeText(input.value);
                }

        };
    }">

        <x-ui.modal.header>
            {{ __('ui/modals.share.title') }}
        </x-ui.modal.header>
        <div class="modal-body">
            <div class="mb-3">
                <label for="link" class="form-label">{{ __('ui/modals.share.labels.link') }}</label>
                <div class="mb-2">
                    <small class="text-muted">
                        {{ __('ui/modals.share.text.link') }}
                    </small>
                </div>

                <div class="input-group">
                    <input type="text" class="form-control" id="link" value="{{ $link }}" readonly>
                    <button class="btn btn-outline-primary" @click="copyToClipboard('link')">
                        <i class="bi bi-clipboard me-1"></i>
                        {{ __('ui/modals.share.button.copy') }}
                    </button>
                </div>
                <div class="mt-2">
                    <small class="text-muted" x-show="link">
                        {{ __('ui/modals.share.text.text_copied') }}
                    </small>
                </div>
            </div>

            <div class="mb-3">
                <label for="admin_key" class="form-label">{{ __('ui/modals.share.labels.admin_link') }}</label>
                <div class="mb-2">
                    <small class="text-muted">
                        {{ __('ui/modals.share.text.admin_link') }}</small>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" id="admin_key" value="{{ $adminLink }}" readonly>
                    <button class="btn btn-outline-primary" @click="copyToClipboard('admin_key')">
                        <i class="bi bi-clipboard me-1"></i>
                        {{ __('ui/modals.share.button.copy') }}
                    </button>
                </div>
                <div class="mt-2">
                    <small class="text-muted" x-show="admin_link">
                        {{ __('ui/modals.share.text.text_copied') }}
                    </small>
                </div>
            </div>
        </div>

    </div>

</div>
