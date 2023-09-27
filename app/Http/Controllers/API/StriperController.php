<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        'amount' => $data['amount'], // Importo in centesimi (ad esempio, $10.00)
        'currency' => 'eur',
        'description' => 'Prenotazione '. $data['data']['pranzoOCena'] . ' del ' . $data['data']['data']  // Valuta desiderata
    ]);

        return response()->json([
            'token' => (string) Str::uuid(),
            'client_secret' => $paymentIntent->client_secret,
            'data' => $paymentIntent['description']
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

        // Loop through the customer array and save bookings
        foreach ($data['customer'] as $customerData) {
            // Assuming you have a Booking model
            $booking = new Booking();
            $booking->reservation_date_id = $customerData['reservation_date_id'];
            $booking->client_id = 1;
            $booking->posto = $customerData['posto'];
            // Add any other fields you need to save

            // Save the booking
            $booking->save();
        }

        return Inertia::render('Thanks');
    }

    public function failPayment(Request $request){
        $data = $request->all();
        return Inertia::render('PaymentError', [
            'error' => $data['code']
        ]);
    }
}
