<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Registration;
use App\Models\WebhookEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;

class WebhookController extends Controller
{
    public function mercadopago(Request $request)
    {
        // Registrar webhook recebido
        $webhookEvent = WebhookEvent::create([
            'provider' => 'mercadopago',
            'event_type' => $request->input('type'),
            'request_id' => $request->header('x-request-id'),
            'payload_json' => $request->all(),
            'processing_status' => 'received',
        ]);

        try {
            // Processar apenas notificações de pagamento
            if ($request->input('type') !== 'payment') {
                $webhookEvent->markAsProcessed();
                return response()->json(['status' => 'ok'], 200);
            }

            $paymentId = $request->input('data.id');
            
            if (!$paymentId) {
                throw new \Exception('Payment ID não encontrado no webhook');
            }

            // Consultar detalhes do pagamento no Mercado Pago
            MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));
            $client = new PaymentClient();
            $mpPayment = $client->get($paymentId);

            // Buscar pagamento no banco pela referência externa
            $externalReference = $mpPayment->external_reference;
            $registration = Registration::where('code', $externalReference)->first();

            if (!$registration) {
                throw new \Exception("Inscrição não encontrada: {$externalReference}");
            }

            DB::beginTransaction();

            // Atualizar ou criar registro de pagamento
            $payment = Payment::updateOrCreate(
                ['registration_id' => $registration->id],
                [
                    'mp_payment_id' => $paymentId,
                    'mp_preference_id' => $mpPayment->preference_id ?? null,
                    'external_reference' => $externalReference,
                    'amount_cents' => $mpPayment->transaction_amount * 100,
                    'currency' => $mpPayment->currency_id,
                    'status' => $this->mapMercadoPagoStatus($mpPayment->status),
                    'status_detail' => $mpPayment->status_detail,
                    'payload_json' => [
                        'id' => $mpPayment->id,
                        'status' => $mpPayment->status,
                        'status_detail' => $mpPayment->status_detail,
                        'payment_method' => $mpPayment->payment_method_id,
                        'transaction_amount' => $mpPayment->transaction_amount,
                    ],
                ]
            );

            // Atualizar status da inscrição
            $this->updateRegistrationStatus($registration, $payment->status);

            DB::commit();

            $webhookEvent->markAsProcessed();

            Log::info('Webhook processado com sucesso', [
                'payment_id' => $paymentId,
                'registration_code' => $externalReference,
                'status' => $mpPayment->status,
            ]);

            return response()->json(['status' => 'ok'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Erro ao processar webhook', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $webhookEvent->markAsFailed($e->getMessage());

            // Sempre retornar 200 para o Mercado Pago não reenviar
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 200);
        }
    }

    private function mapMercadoPagoStatus(string $mpStatus): string
    {
        return match($mpStatus) {
            'approved' => 'approved',
            'pending', 'in_process', 'in_mediation' => 'pending',
            'rejected', 'cancelled' => 'rejected',
            'refunded' => 'refunded',
            'charged_back' => 'charged_back',
            default => 'pending',
        };
    }

    private function updateRegistrationStatus(Registration $registration, string $paymentStatus): void
    {
        $newStatus = match($paymentStatus) {
            'approved' => 'paid',
            'pending' => 'pending_payment',
            'rejected', 'cancelled' => 'registered', // Volta para registered para permitir nova tentativa
            'refunded' => 'refunded',
            default => $registration->status,
        };

        if ($registration->status !== $newStatus) {
            $registration->update(['status' => $newStatus]);

            // TODO: Enviar e-mail quando status mudar para 'paid'
            if ($newStatus === 'paid') {
                Log::info('Pagamento confirmado - enviar e-mail', [
                    'registration_code' => $registration->code,
                    'user_email' => $registration->user->email,
                ]);
            }
        }
    }
}
