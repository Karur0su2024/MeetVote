@props([
    'brand' => '',
    'leftSideActions' => '',
    'rightSideActions' => ''
])

<nav class=" bg-gray-900 shadow-sm transition-all rounded-box">
    <div class="navbar max-w-7xl mx-auto px-3 h-10 items-center">
        <div class="navbar-start gap-4 text-white">
            <div class="flex items-center">
                {{ $brand }}
            </div>
            <div class="menu menu-horizontal hidden md:flex items-center m-0 gap-3 text-white">
                {{ $leftSideActions }}
            </div>
        </div>
        <div class="navbar-end flex items-center gap-3">
            <div class="menu menu-horizontal px-1 flex items-center gap-4 m-0">
                {{ $rightSideActions }}
            </div>
        </div>

    </div>

</nav>
