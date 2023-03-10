<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pagesController extends Controller
{
    //handle requests for the static pages

    public function about() {
        return view('pages/about');
    }

    public function services() {
        return view('pages/services');
    }
}
