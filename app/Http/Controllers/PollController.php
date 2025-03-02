<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Poll;

class PollController extends Controller
{
    
    public function create()
    {
        return view('pages.polls.create');
    }

    public function show(Poll $poll)
    {
        return view('pages.polls.show', ['poll' => $poll]);
    }

    public function edit(Poll $poll)
    {
        return view('pages.polls.edit', ['poll' => $poll]);
    }

}
