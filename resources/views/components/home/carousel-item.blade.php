@props ([
    'title',
    'description',
    'imageUrl',
    'active' => false
])

<div class="carousel-item {{ $active ? 'active' : '' }}">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">{{ $title }}</h3>
                    <p class="card-text">{{ $description }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <img src="{{ $imageUrl }}" class="d-block w-100" alt="{{ $title }}">
        </div>
    </div>
</div>