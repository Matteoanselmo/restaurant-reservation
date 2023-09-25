<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\StripeClient;
use Stripe\PaymentIntent;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Stripe\Stripe;

class StriperController extends Controller
{
    public function initiatePayment(Request $request)
    {
        $data = $request->all();
        Stripe::setApiKey(env('STRIPE_SECRET'));

    // Crea un intento di pagamento con un importo e una valuta desiderati
    $paymentIntent = PaymentIntent::create([
        'amount' => $data['amount'], // Importo in centesimi (ad esempio, $10.00)
        'currency' => 'eur',
        'description' => 'Prenotazione ' // Valuta desiderata
    ]);

        return response()->json([
            'token' => (string) Str::uuid(),
            'client_secret' => $paymentIntent->client_secret
        ]);
    }

    public function completePayment(Request $request)
    {
        $data = $request->all();
        $stripe = new StripeClient(env('STRIPE_SECRET'));

        // // Use the payment intent ID stored when initiating payment
        $paymentDetail = $stripe->paymentIntents->retrieve($data['token']);

        if ($paymentDetail->status != 'succeeded') {
            return Inertia::render('PaymentError');
        }

        // return response()->json([
        //     'message' => $data
        // ]);

        // Complete the payment
    }

    public function failPayment(Request $request){
        $data = $request->all();
        return Inertia::render('PaymentError', [
            'error' => $data['code']
        ]);
    }
}
