<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        session(['locale' => $lang]);
        return redirect()->back();
    }


}
