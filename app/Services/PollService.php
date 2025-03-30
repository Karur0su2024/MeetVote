<?php

namespace App\Services;

use App\Models\Poll;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Events\PollCreated;
use Carbon\Carbon;
use App\Exceptions\PollException;
use Illuminate\Support\Facades\Hash;

class PollService
{
    protected TimeOptionService $timeOptionService;
    protected QuestionService $questionService;


    /**
     * @param TimeOptionService $timeOptionService
     * @param QuestionService $questionService
     */
    public function __construct(TimeOptionService $timeOptionService, QuestionService $questionService)
    {
        // Inicializace služeb
        $this->timeOptionService = $timeOptionService;
        $this->questionService = $questionService;
    }

    /**
     * @return QuestionService
     */
    public function getQuestionService(): QuestionService
    {
        return $this->questionService;
    }

    /**
     * @return TimeOptionService
     */
    public function getTimeOptionService(): TimeOptionService
    {
        return $this->timeOptionService;
    }

}
