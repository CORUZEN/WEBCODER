<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Event $event)
    {
        // Validações
        if (!$event->isRegistrationOpen()) {
            return back()->with('error', 'As inscrições para este evento não estão abertas.');
        }

        if ($event->isFull()) {
            return back()->with('error', 'Este evento está lotado.');
        }

        if (auth()->user()->hasRegisteredFor($event->id)) {
            return back()->with('error', 'Você já está inscrito neste evento.');
        }

        try {
            DB::beginTransaction();

            // Criar inscrição
            $registration = Registration::create([
                'user_id' => auth()->id(),
                'event_id' => $event->id,
                'status' => $event->isFree() ? 'registered' : 'pending_payment',
            ]);

            // Se for evento pago, redirecionar para pagamento
            if ($event->isPaid()) {
                DB::commit();
                return redirect()->route('payment.create', $registration->code)
                    ->with('success', 'Inscrição criada! Complete o pagamento para confirmar.');
            }

            // Evento gratuito - inscrição confirmada
            DB::commit();
            
            // TODO: Enviar e-mail de confirmação
            
            return redirect()->route('user.registrations.show', $registration->code)
                ->with('success', 'Inscrição confirmada com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Erro ao criar inscrição', [
                'event_id' => $event->id,
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Erro ao processar inscrição. Tente novamente.');
        }
    }
}
