<?php

namespace App\Livewire\Forms;

use App\Services\VoteService;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;
use Illuminate\Support\Facades\DB;
use App\Models\Vote;
use App\Models\Poll;

class VotingForm extends Form
{
    public $pollIndex = null;

    // Uživatelské jméno a email
    public $user = [
        'name' => '',
        'email' => '',
    ];

    // Časové možnosti
    public $timeOptions = [];

    // Možnosti otázek
    public $questions = [];

    //
    public $existingVote;

    // Definice validací
    protected $rules = [
        'user.name' => 'required|string|min:3|max:255',
        'user.email' => 'required|email',
        'existingVote' => 'nullable|integer',
        'timeOptions.*.picked_preference' => 'required|integer|min:-1|max:2',
        'timeOptions.*.id' => 'required|integer',
        'questions.*.id' => 'required|integer',
        'questions.*.options.*.id' => 'required|integer',
        'questions.*.options.*.picked_preference' => 'required|integer|in:0,1',
    ];

    public function loadData($data)
    {
        $this->pollIndex = $data['poll_index'] ?? null;

        if (Auth::check()) {
            $this->user['name'] = Auth::user()->name;
            $this->user['email'] = Auth::user()->email;
        } else {
            $this->user['name'] = $data['user']['name'] ?? '';
            $this->user['email'] = $data['user']['email'] ?? '';
        }

        $this->timeOptions = $data['time_options'];
        $this->questions = $data['questions'];
        $this->existingVote = null;
    }


    public function submit(VoteService $voteService, $pollId): bool
    {
        $validatedData = $this->validate();

        $validatedData['poll_id'] = $pollId;

        return $this->saveVote($validatedData, $voteService) !== null;


    }

    private function saveVote($validatedData, VoteService $voteService): ?Vote
    {
        DB::beginTransaction();
        try{
            if (!$voteService->atLeastOnePickedPreference($validatedData)) {
                throw new \Exception('No option selected');
            }

            $vote = $voteService->saveVote($validatedData);


            if (isset($validatedData['existingVote'])) {
                session()->flash('success', 'Vote has been updated successfully.');
            } else {
                session()->flash('success', 'Vote has been created successfully.');
            }

            DB::commit();

            $poll = Poll::find($validatedData['poll_id']);
            $this->loadData($voteService->getPollData($poll));
            return $vote;

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            session()->flash('error', $e->getMessage());
            return null;
        }

    }
}
