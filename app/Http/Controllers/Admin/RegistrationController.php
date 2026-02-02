<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $query = Registration::with('user', 'event', 'payment');

        // Filtros
        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('code', 'like', "%{$search}%");
        }

        $registrations = $query->orderBy('created_at', 'desc')->paginate(20);

        // Para o select de eventos no filtro
        $events = \App\Models\Event::orderBy('title')->get();

        return view('admin.registrations.index', compact('registrations', 'events'));
    }

    public function show(Registration $registration)
    {
        $registration->load('user', 'event', 'payment');
        return view('admin.registrations.show', compact('registration'));
    }

    public function cancel(Registration $registration)
    {
        if ($registration->isCancelled()) {
            return back()->with('error', 'Esta inscrição já está cancelada.');
        }

        $registration->update([
            'status' => 'cancelled',
            'notes' => 'Cancelado pelo administrador em ' . now()->format('d/m/Y H:i'),
        ]);

        // TODO: Enviar e-mail notificando cancelamento

        return back()->with('success', 'Inscrição cancelada com sucesso.');
    }
}
