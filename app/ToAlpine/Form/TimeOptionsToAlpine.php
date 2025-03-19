<?php

namespace App\ToAlpine\Form;

use App\Livewire\Forms\PollForm;
use App\Models\Poll;
use App\Services\PollService;
use Livewire\Component;
use App\Services\NotificationService;
use App\Exceptions\PollException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

trait TImeOptionsToAlpine
{
    // Funkce pro přidání data
    // Volá se po výběru dne v kalendáři

    public function addDate($date): void
    {
        $this->resetErrorBag('form.dates');

        $date = Carbon::parse($date)->format('Y-m-d');


        // Kontrola zda je datum již přidáno
        if (isset($this->form->dates[$date])) {
            $this->addError('form.dates', 'This date has already been added.');

            return;
        }

        $isNotPast = Carbon::parse($date)->isFuture() || Carbon::parse($date)->isToday();

        if (! $isNotPast) {
            $this->addError('form.dates', 'You cannot add a date in the past.');
            return;
        }

        $this->form->dates[$date] = [];

        $this->addTimeOption($date, 'time');

        ksort($this->form->dates);

    }

    // Funkce pro odstranění data
    // V případě, že je poslední časová možnost, nelze ji odstranit
    // Odstraní také všechny časové možnosti uvnitř data
    public function removeDate($date): bool
    {
        $this->resetErrorBag('form.dates');

        if (!isset($this->form->dates[$date])) {
            $this->addError('form.dates', 'The selected date does not exist.');
            return false;
        }

        if (count($this->form->dates) < 2) {
            $this->addError('form.dates', 'You must have at least one date.');
            return false;
        }

        foreach ($this->form->dates[$date] as $optionIndex => $option) {
            if (isset($option['id'])) {
                $this->form->removed['time_options'][] = $option['id'];
            }
        }

        unset($this->form->dates[$date]);
        ksort($this->form->dates);

        return true;
    }

    // Funkce pro přidání časové možnosti
    // Vkládá se datum a typ časové možnosti
    // Typ může být 'time' nebo 'text'
    public function addTimeOption($date, $type): void
    {
        $this->resetErrorBag('form.dates');

        if (isset($this->form->timeOptions[$date])) {
            // přidat error
            return;
        }

        $this->form->dates[$date][] = $this->pollService->getTimeOptionService()->addNewOption($date, $type, $this->pollService->getTimeOptionService()->getLastEnd($this->form->dates[$date]));

        ksort($this->form->dates);
    }

    // Funkce pro odstranění časové možnosti
    // Vkládá se datum a index odstraněné možnosti
    public function removeTimeOption($date, $optionIndex): void
    {
        $this->resetErrorBag('form.dates');

        if (! isset($this->form->dates[$date][$optionIndex])) {
            $this->addError('form.dates', 'This time option does not exist.');
            return;
        }

        $removedOptionId = $this->form->dates[$date][$optionIndex]['id'] ?? null;

        // Pokud je poslední časová možnost
        if (count($this->form->dates[$date]) === 1) {
            // Pokud je poslední datum, nelze jej odstranit
            if (count($this->form->dates) === 1) {
                $this->addError('form.dates', 'You must have at least one date.');
                return;
            }

            if(!$this->removeDate($date)) {
                return;
            }
        }
        else {
            unset($this->form->dates[$date][$optionIndex]);
            $this->form->dates[$date] = array_values($this->form->dates[$date]);
        }

        // Pokud měla možnost záznam v databázi, přidat ji do pole odstraněných
        if (isset($removedOptionId)) {
            $this->form->removed['time_options'][] = $removedOptionId;
        }
    }
}
