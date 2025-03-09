<?php

namespace App\Traits\Poll\PollPage;

trait Preferences
{
    // Metoda pro změnu preference časové možnosti
    public function changePreference($optionIndex, $questionIndex = null)
    {
        // dd('test');
        // dd($questionIndex);
        // dd('test');

        if ($questionIndex !== null) {
            $option = &$this->questions[$questionIndex]['options'][$optionIndex];

            // dd($option);
            switch ($option['chosen_preference']) {
                case 0:
                    $option['chosen_preference'] = 2;
                    break;
                case 2:
                    $option['chosen_preference'] = 0;
                    break;
            }
            // dd($option);
        } else {
            $option = &$this->timeOptions[$optionIndex];

            switch ($option['chosen_preference']) {
                case 0:
                    $option['chosen_preference'] = 2;
                    break;
                case 2:
                    $option['chosen_preference'] = 1;
                    break;
                case 1:
                    $option['chosen_preference'] = -1;
                    break;
                case -1:
                    $option['chosen_preference'] = 0;
                    break;
            }
            // dd($option);
        }
    }

    // Metoda pro změnu preference otázky
    public function changeQuestionPreference($questionIndex, $optionIndex)
    {
        switch ($this->questions[$questionIndex]['options'][$optionIndex]['chosen_preference']) {
            case 0:
                $this->questions[$questionIndex]['options'][$optionIndex]['chosen_preference'] = 2;
                break;
            case 2:
                $this->questions[$questionIndex]['options'][$optionIndex]['chosen_preference'] = 0;
                break;
        }
    }

    private function resetOptions()
    {

        // Resetování formuláře pro hlasování
        $this->resetTimeOptions();
        $this->resetQuestionOptions();
    }

    // Metoda pro resetování časových možností
    private function resetTimeOptions()
    {
        $this->timeOptions = [];
        foreach ($this->poll->timeOptions as $timeOption) {
            $votes = [
                'yes' => 0,
                'maybe' => 0,
                'no' => 0,
                'total' => 0,
            ];

            foreach ($timeOption->votes as $vote) {
                switch ($vote->preference) {
                    case 2:
                        $votes['yes']++;
                        $votes['total'] = $votes['total'] + 2;
                        break;
                    case 1:
                        $votes['maybe']++;
                        $votes['total'] = $votes['total'] + 1;
                        break;
                    case -1:
                        $votes['no']++;
                        $votes['total'] = $votes['total'] - 1;
                        break;
                }
            }

            $this->timeOptions[$timeOption->id] = [
                'id' => $timeOption->id,
                'date' => $timeOption->date,
                'start' => $timeOption->start,
                'text' => $timeOption->text,
                'minutes' => $timeOption->minutes,
                'chosen_preference' => 0,
                'votes' => $votes,
            ];
        }
    }

    // Metoda pro resetování otázek a jejich možností
    private function resetQuestionOptions()
    {
        $this->questions = [];
        foreach ($this->poll->questions as $question) {
            $this->questions[$question->id] = [
                'id' => $question->id,
                'text' => $question->text,
                'options' => [],
            ];

            foreach ($question->options as $option) {
                $votes = [
                    'yes' => 0,
                ];

                $votes['yes'] = count($option->votes);

                $this->questions[$question->id]['options'][$option->id] = [
                    'id' => $option->id,
                    'text' => $option->text,
                    'chosen_preference' => 0,
                    'votes' => $votes,
                ];
            }
        }
    }
}
