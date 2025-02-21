<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Stripe\Stripe as StripeGateway;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function index(Request $request)
    {
        $data = $request->all();
        StripeGateway::setApiKey('STRIPE_SECRET_KEY');

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $data['amount'], // Multiply as & when required
                'currency' => $request->currency,
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            // Save the $paymentIntent->id to identify this payment later
        } catch (\Exception $e) {
            // throw error
        }

        return [
            'token' => (string) Str::uuid(),
            'client_secret' => $paymentIntent->client_secret
        ];

        // $client = Client::create(
        //         [
        //             'mail' => $data['_rawValue']['email'],
        //             'nome' => $data['_rawValue']['first_name'],
        //             'cognome' => $data['_rawValue']['last_name'],
        //             'numero_di_telefono' => $data['_rawValue']['n_phone'],
        //         ]
        // );

        // try {
        //     $payment = $client->charge(
        //         $data['amount'],
        //         $data['payment_method_id']
        //         // $request->input('amount'),
        //         // $request->input('payment_method_id')
        //     );

        //     $payment = $payment->asStripePaymentIntent();
        //     return response()->json([
        //         'message' => 'Ora manca la create degli ordini'
        //     ]);

        // } catch(\Exception $e) {
        //     return response()->json([
        //         'message' => $e->getMessage()
        //     ]);
        // }
    }
}
