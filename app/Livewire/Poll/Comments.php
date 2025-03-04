<?php

namespace App\Livewire\Poll;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Comments extends Component
{
    public $poll;
    public $comments;
    public $username;
    public $content;


    public function mount($poll)
    {
        $this->poll = $poll;
        $this->comments = $poll->comments()->latest()->get();
        $this->resetForm();
    }


    private function resetForm(){
        $this->username = Auth::user()->name;
        $this->content = '';
    }

    public function addComment(){
        $this->validate([
            'content' => 'required|string|max:1000',
        ]);



        $this->poll->comments()->create([
            'author_name' => $this->username,
            'content' => $this->content,
            'user_id' => Auth::id(),
        ]);

        $this->resetForm();
        $this->comments = $this->poll->comments()->latest()->get();



    }

    public function render()
    {
        return view('livewire.poll.comments');
    }
}
