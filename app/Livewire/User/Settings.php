<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Settings extends Component
{

    public $name;
    public $email;
    public $current_password;
    public $new_password;
    public $password_confirmation;


    public function mount()
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }


    // Metoda pro aktualizaci jména a emailu
    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        Auth::user()->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

    }

    public function updatePassword()
    {
        if(!Hash::check($this->current_password, Auth::user()->password)){
            return;
        }

        $this->validate([
            'password' => 'required|string|min:8|confirmed|different:current_password',
        ]);

        //dd($this->password);
        Auth::user()->update([
            'password' => bcrypt($this->new_password),
        ]);



        $this->current_password = '';
        $this->new_password = '';
        $this->password_confirmation = '';

    }

    public function deleteAccount(){
        Auth::user()->delete();
        return redirect()->route('login');
    }


    public function render()
    {
        return view('livewire.user.settings');
    }
}
