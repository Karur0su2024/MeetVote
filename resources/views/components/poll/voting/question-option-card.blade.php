@props(['poll'])

<div class="card card-sharp voting-card border-start-0 border-end-0 p-3 transition-all"
      :class="'voting-card-' + option.picked_preference">
    <div class="card-body voting-card-body">
        <div class="d-flex justify-content-between align-items-center">
            <!-- Option content -->
            <div class="me-2 w-25">
                <h6 class="mb-0" x-text="option.text"></h6>
            </div>

            <!-- Vote count -->
            <div
                class="d-flex flex-column align-items-center px-2 py-1 me-2 w-50">
                @if (!$poll->hide_results)
                    <span x-text="option.score"
                          class="fw-bold badge shadow-sm bg-light text-dark fs-6"></span>
                @endif
            </div>



            <!-- Preference selection -->
            <div>
                <button
                        @click="setPreference('question', questionIndex, optionIndex, getNextPreference('question', option.picked_preference))"
                        class="btn btn-outline-vote d-flex align-items-center"
                        :class="'btn-outline-vote-' + option.picked_preference"
                        type="button">
                    <img class="p-1"
                         :src="'{{ asset('icons/') }}/' + option.picked_preference + '.svg'"
                         :alt="option.picked_preference"/>
                </button>
            </div>
        </div>
    </div>
</div>
