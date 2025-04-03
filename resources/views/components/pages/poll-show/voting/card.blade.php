@props(['poll'])

<div class="card card-sharp voting-card border-start-0 border-end-0 p-3 transition-all"
     {{ $attributes }}>
    <div class="card-body voting-card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div class="me-2 w-25">
                {{ $content }}
            </div>

            <div class="d-flex flex-column align-items-center px-2 py-1 me-2 w-50">
                @if (!$poll->hide_results)
                    <span {{ $score->attributes }}
                          class="fw-bold badge shadow-sm bg-light text-dark fs-6"></span>
                @endif
            </div>

            <!-- Preference -->
            <div>
                <button {{ $button->attributes ?? '' }}
                        class="btn btn-outline-vote d-flex align-items-center"
                        type="button">
                    {{ $button ?? '' }}
                </button>
            </div>
        </div>
    </div>
</div>
