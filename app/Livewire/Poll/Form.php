<?php

namespace App\Livewire\Poll;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use App\Models\Poll;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Traits\PollForm\Options;
use App\Traits\PollForm\PollData;

class Form extends Component
{

    // Načtení dat ankety
    use PollData;

    // Načtení možností ankety
    use Options;

    public $poll;

    // Metoda mount
    function mount($poll = null)
    {
        if ($this->poll = $poll) {
            $this->loadExistingPoll();
        } else {
            $this->loadNewPoll();
        }
    }


    private function loadNewPoll()
    {
        // Pokud je uživatel přihlášený, načtou se jeho údaje
        if (Auth::check()) {
            $this->userName = Auth::user()->name;
            $this->userEmail = Auth::user()->email;
        }

        // Přidání prvního data
        $this->addDate(date('Y-m-d'));
    }

    private function loadExistingPoll()
    {
        $this->title = $this->poll->title;
        $this->description = $this->poll->description;
        $this->deadline = $this->poll->deadline;
        $this->userName = $this->poll->author_name;
        $this->userEmail = $this->poll->author_email;
        $this->settings['anonymous'] = $this->poll->anonymous_votes == 1 ? true : false;
        $this->settings['comments'] = $this->poll->comments == 1 ? true : false;
        $this->settings['hide_results'] = $this->poll->hide_results == 1 ? true : false;
        $this->settings['invite_only'] = $this->poll->invite_only == 1 ? true : false;
        $this->settings['password'] = $this->poll->password;


        // Načtení časových možností
        $this->loadTimeOptions();

        // Načtení otázek
        $this->loadQuestions();
    }



    // Odeslání formuláře
    public function submit()
    {
        // Validace
        $validatedData = $this->validate();

        // Kontrola duplicit
        if (!$this->checkDuplicate($validatedData)) {
            return;
        }

        // Uložení změn ankety
        if ($poll = $this->save($validatedData)) {


            // Uložení klíče správce ankety do session
            session()->put('poll_' . $poll->public_id . '_adminKey', $poll->admin_key);

            return redirect()->route('polls.show', $poll);
        } else {
            return;
        }
    }



    private function save($validatedData): ?Poll
    {

        // Započetí transakce, pokud se něco nepovede, vrátí se zpět
        DB::beginTransaction();

        try {
            if ($poll = $this->poll) {

                // Uložení změn ankety
                $poll->update([
                    'title' => $validatedData['title'],
                    'description' => $validatedData['description'],
                    'deadline' => $validatedData['deadline'],
                    'anonymous_votes' => $validatedData['settings']['anonymous'],
                    'comments' => $validatedData['settings']['comments'],
                    'hide_results' => $validatedData['settings']['hide_results'],
                    'invite_only' => $validatedData['settings']['invite_only'],
                    'password' => $validatedData['settings']['password'],
                ]);
    
                // Odstranění existujících možností
                $this->removeDeletedOptions();
    
    
                // Uložení časových možností a otázek
                $this->saveOptions($this->poll, $validatedData);
            }
            else {

                // Vytvoření nové ankety
                $poll = Poll::create([
                    'title' => $validatedData['title'],
                    'public_id' => Str::random(40),
                    'admin_key' => Str::random(40),
                    'author_name' => $validatedData['user_name'],
                    'author_email' => $validatedData['user_email'],
                    'user_id' => Auth::id(),
                    'deadline' => $validatedData['deadline'],
                    'description' => $validatedData['description'],
                    'comments' => $validatedData['settings']['comments'],
                    'anonymous_votes' => $validatedData['settings']['anonymous'],
                    'hide_results' => $validatedData['settings']['hide_results'],
                    'invite_only' => $validatedData['settings']['invite_only'],
                    'password' => $validatedData['settings']['password'],
                    'status' => 'active',
                ]);
    
                // Uložení časových možností a otázek
                $this->saveOptions($poll, $validatedData);
            }

            DB::commit();

            return $poll;
        }
        catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return null;
        }
    }



    public function render()
    {
        return view('livewire.poll.form');
    }
}
