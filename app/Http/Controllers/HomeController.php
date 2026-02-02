<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $upcomingEvents = Event::published()
            ->upcoming()
            ->orderBy('start_at')
            ->take(3)
            ->get();

        return view('home', compact('upcomingEvents'));
    }

    public function about()
    {
        return view('about');
    }

    public function worship()
    {
        return view('worship');
    }

    public function youth()
    {
        return view('youth');
    }

    public function contact()
    {
        return view('contact');
    }
}
