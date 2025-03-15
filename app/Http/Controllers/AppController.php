<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class AppController extends Controller
{

    public function toggleDarkMode(Request $request)
    {
        if (session('darkmode')) {
            session()->forget('darkmode');
        } else {
            session(['darkmode' => 'dark']);
        }
        return redirect()->back();
    }

    public function changeLanguage(Request $request, $lang)
    {
        if (in_array($lang, ['en', 'cs'])) {
            session(['language' => $lang]);
        }

        return redirect()->back();
    }


}
