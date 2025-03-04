<?php

namespace App\Livewire\Poll;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class Comments extends Component
{
    public $poll;
    public $comments;
    public $username;
    public $content;

    // Načtení komentářů
    public function mount($poll)
    {
        $this->poll = $poll;
        $this->comments = $poll->comments()->latest()->get();
        $this->resetForm();
    }


    // Resetování formuláře
    private function resetForm(){
        if (Auth::check()) {
            $this->username = Auth::user()->name;
        }
        else {
            $this->username = '';
        }

        $this->content = '';
    }


    // Validace formuláře
    public function addComment(){
        $this->validate([
            'username' => 'nullable|string|max:255',
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

    // Smazání komentáře
    public function deleteComment($commentIndex){
        $comment = Comment::find($commentIndex);

        // Kontrola, zda je komentář v databázi
        if($comment){
            $comment->delete();
        };

        // Nové načtení komentářů
        $this->comments = $this->poll->comments()->latest()->get();
    }

    // Zobrazení komponenty
    public function render()
    {
        return view('livewire.poll.comments');
    }
}
