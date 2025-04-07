<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Auth;
use Livewire\Form;
/**
 *
 */
class VotingForm extends Form
{
    public $pollIndex = null;

    public $user = [
        'name' => '',
        'email' => '',
    ];
    public $notes = '';


    public $timeOptions = [];
    public $questions = [];
    public $existingVote;

    protected function rules(): array {
        return [
            'user.name' => 'required|string|min:3|max:255',
            'user.email' => 'required|email',
            'existingVote' => 'nullable|integer',
            'timeOptions.*.picked_preference' => 'required|integer|min:-1|max:2',
            'timeOptions.*.id' => 'required|integer',
            'questions.*.id' => 'required|integer',
            'questions.*.options.*.id' => 'required|integer',
            'questions.*.options.*.picked_preference' => 'required|integer|in:0,2',
            'notes' => 'nullable|string',
        ];
    }

    /**
     * @var string[]
     */
    protected $messages = [
        'user.name.required' => 'Name is required.',
        'user.email.required' => 'Email is required.',
        'timeOptions.*.picked_preference.required' => 'Preference is required.',
        'timeOptions.*.picked_preference.min' => 'Invalid preference value.',
        'timeOptions.*.picked_preference.max' => 'Invalid preference value.',
        'questions.*.options.*.id.required' => 'Option ID is required.',
        'questions.*.options.*.picked_preference.in' => 'Invalid preference value.',
    ];

    /**
     * Funkce pro inicializaci komponenty
     * @param $data
     * @return void
     */
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

        $this->notes = $data['message'] ?? '';

        $this->timeOptions = $data['time_options'];
        $this->questions = $data['questions'];
        $this->existingVote = $data['vote_index'] ?? null;

    }


}
