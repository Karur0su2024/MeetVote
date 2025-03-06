<?php

namespace App\Livewire\Poll;

use Livewire\Component;
use App\Models\TimeOption;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Carbon\Carbon;
use App\Models\PollQuestion;
use App\Models\QuestionOption;
use App\Traits\PollForm\Options;
use App\Traits\PollForm\PollData;


class FormEdit extends Component
{

    use PollData;

    use Options;

    public $poll;






    public function submit(){
        $validatedData = $this->validate();

        // Kontrola duplicit
        if(!$this->checkDuplicate($validatedData)){
            
            return;
        }

        // Uložení změn ankety
        if(!$this->save($validatedData)){
            return;
        }

        return redirect()->route('polls.show', $this->poll);

    }


    private function save($validatedData) : bool {
        // Vytvoření nové ankety


        DB::beginTransaction();

        try {
            $this->poll->update([
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
            $this->removeExistingOptions();


            // Uložení časových možností a otázek
            $this->saveOptions($this->poll, $validatedData);

            DB::commit();

            return true;
        }
        catch (\Exception $e) {
            DB::rollBack();
            //dd($e);
            return false;


        }

    }




    public function render()
    {
        return view('livewire.poll.form-edit');
    }
}
