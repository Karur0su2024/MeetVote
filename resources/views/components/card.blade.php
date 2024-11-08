@props([
    'col' => '12', 
    'class' => ''
    ])

<div class="card shadow-sm col-lg-{{$col}} mx-auto bg-gradient mb-4 border-0 {{$class}}">
    <div class="card-body p-2">
        {{ $slot }}
    </div>
</div>