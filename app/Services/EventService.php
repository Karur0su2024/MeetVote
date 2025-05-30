<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Poll;

class EventService
{

    // Vytvoření události
    public function createEvent(Poll $poll, $validatedEventData): Event
    {
        $event = $poll->event;

        if($event){
            $poll->event()->update($validatedEventData);
            $event = $poll->event()->first();
        }
        else{
            $event = $poll->event()->create($validatedEventData);
        }

        $poll->load('event');
        return $event;
    }

    // Sestavení události
    public function buildEvent($event): array
    {
        return [
            'poll_id' => $event->poll_id ?? null,
            'title' => $event->title ?? null,
            'start_time' => $event->start_time ? $event->start_time->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s'),
            'end_time' => $event->end_time ? $event->end_time->format('Y-m-d H:i:s') : now()->addHour()->format('Y-m-d H:i:s'),
            'description' => $event->description ?? null,
        ];
    }

    // Sestavení události pro zobrazení v modálním okně
    public function buildEventArrayFromValidatedData($poll, $results): array
    {

        $timeOption = $results['timeOptions']['options'][$results['timeOptions']['selected']]; // Vybraná časovou možnost
        $text = $poll->description ? $poll->description."\n\n" : ''; // Popis události podle popisu ankety


        // Vložení hodnot vybraných možností otázek do popisu události
        if(count($results['questions']) > 0){
            $text .= __('ui/modals.create_event.event_description.questions').":\n";

            foreach ($results['questions'] as $question) {
                $text .= $question['text'].': ';
                $text .= $question['options'][$question['selected']]['text']."\n";
                $text .= "\n";
            }
        }

        return [
            'poll_id' => $poll->id,
            'title' => $poll->title,
            'start_time' => $timeOption['date'] . ' ' . ($timeOption['content']['start'] ?? '00:00'),
            'end_time' => $timeOption['date'] . ' ' . ($timeOption['content']['end'] ?? '01:00'),
            'description' => $text,
        ];
    }

}
