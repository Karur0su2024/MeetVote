<?php

use Livewire\Component;
use App\Models\Comment;
use App\Models\Poll;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public $poll;

    public $comments;

    public $username;

    public $content;

    public $loadedComments = false;

    // Načtení komentářů
    public function mount($pollIndex)
    {

        $this->poll = Poll::find($pollIndex);
        $this->resetForm();
    }

    // Resetování formuláře
    private function resetForm()
    {
        $this->poll->load('pollComments');
        if (Auth::check()) {
            $this->username = Auth::user()->name;
        } else {
            $this->username = '';
        }

        $this->content = '';
    }

    // Načtení komentářů
    public function loadComments()
    {
        $this->loadedComments = false;

        $this->comments = $this->poll->load('pollComments');

        $this->loadedComments = true;
    }

    // Přidání komentáře
    public function addComment()
    {
        $this->validate([
            'username' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
        ]);

        $this->poll->pollComments()->create([
            'author_name' => $this->username,
            'content' => $this->content,
            'user_id' => Auth::id(),
        ]);

        $this->resetForm();
    }

    // Smazání komentáře
    public function deleteComment($commentIndex)
    {
        $comment = Comment::find($commentIndex);

        // Kontrola, zda je komentář v databázi
        if ($comment) {
            $comment->delete();
        }

        $this->resetForm();
    }
};
