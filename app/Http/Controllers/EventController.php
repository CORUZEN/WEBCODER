<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::published()
            ->orderBy('start_at')
            ->paginate(12);

        return view('events.index', compact('events'));
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        $userRegistration = null;
        if (auth()->check()) {
            $userRegistration = auth()->user()->registrations()
                ->where('event_id', $event->id)
                ->first();
        }

        return view('events.show', compact('event', 'userRegistration'));
    }
}
