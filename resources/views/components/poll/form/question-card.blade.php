<div class="card mb-3 shadow-sm">
    <!-- Hlavička otázky -->
    <div class="card-header d-flex justify-content-between align-items-center gap-2">
        {{ $header }}
    </div>

    {{-- Možnosti odpovědí --}}
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
