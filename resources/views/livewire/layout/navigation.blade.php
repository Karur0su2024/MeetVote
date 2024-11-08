<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Actions\Logout;

new class extends Component {

    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
};

?>

<nav class="navbar navbar-expand-lg navbar-light shadow-sm py-3 bg-gradient" style="background: #DBE9E9">
    <div class="container">
        <a class="navbar-brand" href="/">MeetVote</a>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ route('polls.new.settings') }}">Create a poll</a>
            </li>
        </ul>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto">
                @auth

                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            {{ Auth::user()->username }}
                        </button>
                        <ul class="dropdown-menu p-1">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i
                                        class="bi bi-box-fill me-1"></i>Dashboard</a></li>
                            <li><a class="dropdown-item" href=""><i class="bi bi-gear me-1"></i>
                                    Settings</a></li>
                            <li>
                                <hr class="dropdown-divider my-1">
                            </li>
                            <li><button type="button" class="dropdown-item" wire:click='logout'>
                                <i class="bi bi-box-arrow-right me-1"></i> Logout</button>
                            </li>
                        </ul>
                    </div>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>
