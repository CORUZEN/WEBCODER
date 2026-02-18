<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Configurar SDK Mercado Pago
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));
    }

    public function create($registrationCode)
    {
        $registration = Registration::where('code', $registrationCode)
            ->with('event', 'user')
            ->firstOrFail();

        // Verificar se a inscrição pertence ao usuário logado
        if ($registration->user_id !== auth()->id()) {
            abort(403, 'Você não tem permissão para acessar esta inscrição.');
        }

        // Verificar se já não está pago
        if ($registration->isPaid()) {
            return redirect()->route('user.registrations.show', $registration->code)
                ->with('info', 'Esta inscrição já está paga.');
        }

        // Verificar se já existe um pagamento pendente
        $existingPayment = $registration->payment()
            ->whereIn('status', ['created', 'pending'])
            ->first();

        if ($existingPayment && $existingPayment->mp_preference_id) {
            return view('payment.checkout', [
                'registration' => $registration,
                'payment' => $existingPayment,
                'preferenceId' => $existingPayment->mp_preference_id,
            ]);
        }

        // Criar nova preferência no Mercado Pago
        try {
            $client = new PreferenceClient();
            
            $preference = $client->create([
                'items' => [
                    [
                        'title' => $registration->event->title,
                        'description' => 'Inscrição para ' . $registration->event->title,
                        'quantity' => 1,
                        'unit_price' => $registration->event->price_cents / 100,
                        'currency_id' => $registration->event->currency,
                    ]
                ],
                'payer' => [
                    'name' => $registration->user->name,
                    'email' => $registration->user->email,
                    'phone' => [
                        'number' => $registration->user->phone ?? '',
                    ],
                ],
                'external_reference' => $registration->code,
                'back_urls' => [
                    'success' => route('payment.success'),
                    'failure' => route('payment.failure'),
                    'pending' => route('payment.pending'),
                ],
                'auto_return' => 'approved',
                'notification_url' => config('services.mercadopago.notification_url'),
                'statement_descriptor' => 'IAGUS',
            ]);

            // Criar registro de pagamento
            $payment = Payment::create([
                'registration_id' => $registration->id,
                'provider' => 'mercadopago',
                'mp_preference_id' => $preference->id,
                'external_reference' => $registration->code,
                'amount_cents' => $registration->event->price_cents,
                'currency' => $registration->event->currency,
                'status' => 'created',
            ]);

            return view('payment.checkout', [
                'registration' => $registration,
                'payment' => $payment,
                'preferenceId' => $preference->id,
            ]);

        } catch (\Exception $e) {
            Log::error('Erro ao criar preferência Mercado Pago', [
                'registration_code' => $registration->code,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Erro ao processar pagamento. Tente novamente.');
        }
    }

    public function success(Request $request)
    {
        return view('payment.success');
    }

    public function failure(Request $request)
    {
        return view('payment.failure');
    }

    public function pending(Request $request)
    {
        return view('payment.pending');
    }
}
