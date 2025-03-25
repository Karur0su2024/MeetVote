<?php

namespace App\Livewire\Pages\PollShow;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Poll;

class CommentsSection extends Component
{
    public $poll;

    public $comments;

    public $username;

    public $content;

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

    // Validace formuláře
    public function addComment()
    {
        $this->validate([
            'username' => 'nullable|string|max:255',
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

    // Zobrazení komponenty
    public function render()
    {
        return view('livewire.pages.poll-show.comments-section');
    }
}
