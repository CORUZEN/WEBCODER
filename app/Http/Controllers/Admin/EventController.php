<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $events = Event::orderBy('start_at', 'desc')->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:events,slug',
            'description' => 'required|string',
            'instructions' => 'nullable|string',
            'start_at' => 'required|date',
            'end_at' => 'nullable|date|after:start_at',
            'location_name' => 'required|string|max:255',
            'location_address' => 'nullable|string',
            'capacity' => 'nullable|integer|min:1',
            'price_cents' => 'required|integer|min:0',
            'registration_open_at' => 'nullable|date',
            'registration_close_at' => 'nullable|date',
            'status' => 'required|in:draft,published,closed',
            'image_url' => 'nullable|url',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $event = Event::create($validated);

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Evento criado com sucesso!');
    }

    public function show(Event $event)
    {
        $registrations = $event->registrations()
            ->with('user', 'payment')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total' => $event->registrations()->count(),
            'registered' => $event->registrations()->where('status', 'registered')->count(),
            'pending_payment' => $event->registrations()->where('status', 'pending_payment')->count(),
            'paid' => $event->registrations()->where('status', 'paid')->count(),
            'cancelled' => $event->registrations()->whereIn('status', ['cancelled', 'refunded'])->count(),
            'revenue' => Payment::whereHas('registration', function($q) use ($event) {
                $q->where('event_id', $event->id);
            })->where('status', 'approved')->sum('amount_cents'),
        ];

        return view('admin.events.show', compact('event', 'registrations', 'stats'));
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:events,slug,' . $event->id,
            'description' => 'required|string',
            'instructions' => 'nullable|string',
            'start_at' => 'required|date',
            'end_at' => 'nullable|date|after:start_at',
            'location_name' => 'required|string|max:255',
            'location_address' => 'nullable|string',
            'capacity' => 'nullable|integer|min:1',
            'price_cents' => 'required|integer|min:0',
            'registration_open_at' => 'nullable|date',
            'registration_close_at' => 'nullable|date',
            'status' => 'required|in:draft,published,closed',
            'image_url' => 'nullable|url',
        ]);

        $event->update($validated);

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Evento atualizado com sucesso!');
    }

    public function destroy(Event $event)
    {
        if ($event->registrations()->count() > 0) {
            return back()->with('error', 'Não é possível excluir um evento com inscrições.');
        }

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Evento excluído com sucesso!');
    }

    public function export(Event $event)
    {
        $registrations = $event->registrations()
            ->with('user', 'payment')
            ->get();

        $filename = 'inscricoes-' . Str::slug($event->title) . '-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($registrations) {
            $file = fopen('php://output', 'w');
            
            // BOM para UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Cabeçalho
            fputcsv($file, [
                'Código',
                'Nome',
                'Email',
                'Telefone',
                'Status',
                'Valor',
                'Status Pagamento',
                'Data Inscrição',
            ], ';');

            // Dados
            foreach ($registrations as $reg) {
                fputcsv($file, [
                    $reg->code,
                    $reg->user->name,
                    $reg->user->email,
                    $reg->user->phone,
                    $reg->statusLabel(),
                    $reg->event->priceFormatted(),
                    $reg->payment ? $reg->payment->status : 'N/A',
                    $reg->created_at->format('d/m/Y H:i'),
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
