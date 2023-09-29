<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\GuestConfirmedPayment;
use App\Models\Booking;
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
        'amount' => $data['amount'] * 100, // Importo in centesimi (ad esempio, $10.00)
        'currency' => 'eur',
        'description' => 'Prenotazione '. $data['data']['pranzoOCena'] . ' del ' . $data['data']['data']  // Valuta desiderata
    ]);

        return response()->json([
            'token' => $paymentIntent->id,
            'client_secret' => $paymentIntent->client_secret,
            'data' => $paymentIntent['description'],
            'intent' => $paymentIntent
        ]);
    }

    public function completePayment(Request $request)
    {
        $data = $request->all();
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $paymentIntent = $stripe->paymentIntents->retrieve($data['token']);

        if ($paymentIntent->status !== 'succeeded') {
            return response()->json([
                'url' => 'http://192.168.188.32:8000/errore-pagamento'
            ]);
        }
        // Loop through the customer array and save bookings
        foreach ($data['booked'] as $customerData) {
            // Assuming you have a Booking model
            if($customerData['newsletter']){
                Booking::create([
                    'reservation_date_id' => 2,
                    'posto' => $customerData['n_posto']
                ]);
            }
        }

        // Invia l'email personalizzata
        \Mail::to($data['customer']['email'])->send(new GuestConfirmedPayment($data));

        return response()->json([
            'url' => 'http://192.168.188.32:8000/grazie'
        ]);
    }

    public function failPayment(Request $request){
        $data = $request->all();
        return Inertia::render('PaymentError', [
            'error' => $data['code']
        ]);
    }
}
