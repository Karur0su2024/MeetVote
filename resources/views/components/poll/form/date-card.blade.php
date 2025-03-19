<div class="card mb-3 shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong class="card-title m-0" x-text="moment(dateIndex).format('dddd, MMMM D, YYYY')"></strong>
        <button type="button" class="btn btn-sm btn-danger" @click="removeDate(dateIndex)">
            <i class="bi bi-trash"></i> Delete
        </button>
    </div>
    <div class="card-body p-2">
        {{ $slot }}
    </div>
</div>
