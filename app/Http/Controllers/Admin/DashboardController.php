<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $stats = [
            'total_events' => Event::count(),
            'published_events' => Event::where('status', 'published')->count(),
            'total_registrations' => Registration::count(),
            'paid_registrations' => Registration::where('status', 'paid')->count(),
            'pending_payments' => Registration::where('status', 'pending_payment')->count(),
            'total_revenue' => Payment::where('status', 'approved')->sum('amount_cents'),
        ];

        $recentRegistrations = Registration::with('user', 'event')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $upcomingEvents = Event::published()
            ->where('start_at', '>', now())
            ->orderBy('start_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentRegistrations', 'upcomingEvents'));
    }
}
