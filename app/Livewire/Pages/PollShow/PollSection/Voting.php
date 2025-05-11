<?php

namespace App\Livewire\Pages\PollShow\PollSection;

use App\Exceptions\VoteException;
use App\Livewire\Forms\VotingForm;
use App\Models\Poll;
use App\Services\Google\GoogleService;
use App\Services\Vote\VoteCreateService;
use App\Services\Vote\VoteQueryService;
use App\Traits\CanOpenModals;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Nette\Schema\ValidationException;
use App\Models\User;

class Voting extends Component
{

    use CanOpenModals;

    public Poll $poll;

    public VotingForm $form;

    public $loaded = false;

    public function mount($pollIndex, VoteQueryService $voteQueryService): void
    {
        $this->poll = Poll::findOrFail($pollIndex);
        $this->loadVoteSection($voteQueryService);
    }

    private function loadVoteSection(VoteQueryService $voteQueryService): void
    {
        $this->loaded = false;
        $this->form->loadData($voteQueryService->getPollData($this->poll->id));
        $this->loaded = true;
    }

    // Odeslání odpovědi
    public function submitVote(
        VoteCreateService $voteCreateService,
    ): void
    {
        session()->forget('error');

        if(Gate::denies('canVote', $this->poll)) {
            session()->flash('error', __('pages/poll-show.voting.messages.errors.not_allowed'));
            return;
        }


        $validatedData = $this->form->validate();
        if($this->isEmailInvalid()) {
            session()->flash('error', __('pages/poll-show.voting.messages.errors.email_invalid'));
            return;
        }

        if(session()->has('poll.' . $this->poll->id . '.vote') && Auth::guest()){
            session()->flash('error', __('pages/poll-show.voting.messages.errors.already_voted'));
            return;
        }


        try {
            $voteCreateService->saveVote($validatedData);
        } catch (ValidationException $e) {
            Log::error('Error saving vote: ' . $e->getMessage());
            $this->addError('error', __('pages/poll-show.voting.messages.errors.saving_error'));
            throw $e;
        }
        catch (VoteException $e) {
            Log::error('Error saving vote: ' . $e->getMessage());
            session()->flash('error',  $e->getMessage());
            return;
        }
    }

    // Aktualizace formuláře
    #[On('refreshPoll')]
    public function refreshPoll(VoteQueryService $voteQueryService): void
    {
        $this->loadVoteSection($voteQueryService);
        $this->dispatch('show-voting-section');
    }


    // Kontrola dostupnosti
    public function checkAvailability(GoogleService $googleService): void
    {
        $user = Auth::user();

        if(Gate::denies('sync', $user)){
            return;
        }

        date_default_timezone_set($this->poll->timezone);
        $this->form->timeOptions = $googleService->checkAvailability($user, $this->form->timeOptions);


    }

    // Kontrola, zda uživatel může použít zvolenou e-mailovou adresu
    private function isEmailInvalid(): bool
    {
        if(Auth::guest()){
            $vote = $this->poll->votes->where('voter_email', $this->form->user['email'])->first();
            if($vote) {
                return true;
            }
            $user = User::where('email', $this->form->user['email'])->get()->first();
            if($user){
                return true;
            }
        }
        return false;
    }


    public function render()
    {
        return view('livewire.pages.poll-show.poll-section.voting');
    }
}
