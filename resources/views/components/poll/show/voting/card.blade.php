@props([
    'class' => '',
    'content',
    'score',
    'button',
])

<div class="card card-sharp voting-card  border-start-0 border-end-0 p-3 {{ $class }} bg-gradient">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            {{-- Obsah možnosti --}}
            <div>
                {{ $content }}
            </div>

            {{-- Zobrazení hlasů --}}
            <div class="d-flex flex-column">
                {{ $score }}
            </div>

            {{-- Výběr preference časové možnosti --}}
            <div>
                {{ $button }}
            </div>
        </div>
    </div>

</div>
