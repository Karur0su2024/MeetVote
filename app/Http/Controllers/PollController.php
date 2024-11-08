<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poll;

class PollController extends Controller
{
    public function show(Poll $poll)
    {
        return view('poll', compact('poll'));
    }
}
