<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ $poll->title }}</x-slot>

    <div class="container text-start">

        <div class="card">
            <div class="card-header">
                <h1>{{ $poll->title }}</h1>
            </div>
            <div class="card-body">
                @if(session()->has('error'))
                    <x-ui.alert type="danger">
                        {{ session('error') }}
                    </x-ui.alert>
                @endif
                <p>{{ __('pages/password.text') }}</p>
                <form action="{{ route('polls.checkPassword', $poll) }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('pages/password.labels.password') }}</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('pages/password.buttons.submit') }}</button>
                </form>
            </div>
        </div>


    </div>



</x-layouts.app>
