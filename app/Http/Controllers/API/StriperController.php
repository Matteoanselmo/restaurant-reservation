<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\GuestConfirmedPayment;
use App\Mail\MailBookedPrenotationChair;
use App\Models\Booking;
use App\Models\Client;
use App\Models\ReservationDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
            return redirect()->route('error.payment');
        }
        // Loop through the customer array and save bookings
        foreach ($data['booked'] as $customerData) {

            Booking::create([
                'reservation_date_id' => $data['data']['dataId'],
                'posto' => $customerData['n_posto']
            ]);

            $customerData['data'] = $data['data']['data'];
            $customerData['pranzoOCena'] = $data['data']['pranzoOCena'];

            Mail::to($customerData['email'])->send(new MailBookedPrenotationChair($customerData));

            if($customerData['newsletter']){
                Client::create([
                    'nome' => $customerData['nome'],
                    'cognome' => $customerData['cognome'],
                    'email' => $customerData['email'],
                    'n_telefono' => $customerData['n_telefono'],
                ]);

            }
        }
        $reservation_date = ReservationDate::findOrFail($data['data']['dataId']);

        // Verifica se esistono prenotazioni per quella ReservationDate
        $existingBookings = Booking::where('reservation_date_id', $reservation_date->id)->count();
        // Se non ci sono prenotazioni per quella ReservationDate
        if ($existingBookings === 0) {
            // Cerca altre ReservationDate per la stessa data
            $otherReservationDates = ReservationDate::where('data', $reservation_date->data)
                                                    ->where('id', '!=', $reservation_date->id)
                                                    ->get();

            foreach ($otherReservationDates as $otherReservationDate) {
                // Crea 8 nuove prenotazioni per ogni ReservationDate trovata
                for ($i = 0; $i < 8; $i++) {
                    Booking::create([
                        'reservation_date_id' => $otherReservationDate->id,
                        'posto' => $i // Assumi che posto sia numerico e sequenziale
                    ]);
                }
            }
        }
        // Invia l'email Conferma Pagamento
        Mail::to($data['customer']['email'])->send(new GuestConfirmedPayment($data));

        return redirect()->route('thanks.payment', compact('data'));
    }

    public function failPayment(Request $request){
        $data = $request->all();
        return Inertia::render('PaymentError', [
            'error' => $data['code']
        ]);
    }
}
