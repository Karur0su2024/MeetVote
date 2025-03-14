@props([
    'class' => '',
    'content',
    'score',
    'button',
])

<div class="card card-sharp voting-card  border-start-0 border-end-0 p-3 voting-card-{{ $preference ?? 0 }}">
    <div class="card-body voting-card-body">
        <div class="d-flex justify-content-between align-items-center">
            {{-- Obsah možnosti --}}
            <div>

            </div>

            {{-- Zobrazení hlasů --}}
            <div class="d-flex flex-column">

            </div>

            {{-- Výběr preference časové možnosti --}}
            <div>

            </div>
        </div>
    </div>

</div>
