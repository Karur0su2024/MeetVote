@props([
    'results'
])


<div class="flex flex-col gap-1">
    <x-ui.card>
        <div class="flex items-center justify-between">
            <x-ui.text.title-w-icon>
                <x-slot:icon>
                    <x-mary-icon name="o-clock" class="text-xl"/>
                </x-slot:icon>
                <x-slot:title>
                    {{ __('pages/poll-show.results.sections.results.view_only.section.time_options') }}
                </x-slot:title>
            </x-ui.text.title-w-icon>
        </div>
        <div class="grid grid-cols-2 gap-2">
            @foreach($results['timeOptions']['options'] as $optionIndex => $option)
                <div>
                    <x-pages.poll-show.poll.option-card>
                        <x-slot:text>
                            {{ $option['date_formatted'] }}
                        </x-slot:text>
                        <x-slot:subtext>
                            {{ $option['full_content'] }}
                        </x-slot:subtext>
                        <x-slot:bottom>
                            <x-pages.poll-show.poll.results.preference-view :score="$option['score']"
                                                                            :preferences="$option['preferences']"/>
                        </x-slot:bottom>
                    </x-pages.poll-show.poll.option-card>
                </div>
            @endforeach
        </div>
    </x-ui.card>

    @foreach($results['questions'] as $question)
    <x-ui.card>
        <div class="flex items-center justify-between">
            <x-ui.text.title-w-icon>
                <x-slot:icon>
                    <x-mary-icon name="o-question-mark-circle" class="text-xl"/>
                </x-slot:icon>
                <x-slot:title>
                    {{ $question['text'] }}
                </x-slot:title>
            </x-ui.text.title-w-icon>
        </div>
        <div class="grid grid-cols-2 gap-2">
            @foreach($question['options'] as $option)
                <div>
                    <x-pages.poll-show.poll.option-card>
                        <x-slot:text>
                            {{ $option['text'] }}
                        </x-slot:text>
                        <x-slot:bottom>
                            <x-pages.poll-show.poll.results.preference-view :score="$option['score']/2"/>
                        </x-slot:bottom>
                    </x-pages.poll-show.poll.option-card>
                </div>
            @endforeach
        </div>
    </x-ui.card>
    @endforeach


</div>
