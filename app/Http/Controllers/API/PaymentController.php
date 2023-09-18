<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $config = [
            'secret' => env('STRIPE_SECRET'), // La tua chiave API segreta di Stripe
            'key' => env('STRIPE_KEY'), // La tua chiave API pubblica di Stripe
        ];
        Stripe\Stripe::setApiKey($config['secret']);

        $stripe = new \Stripe\StripeClient($config['secret']);
        // Creazione di prodotti statici
    $product1 = $stripe->products->create([
        'name' => 'T-shirt personalizzata',
        'description' => 'Una t-shirt personalizzata con il tuo logo o design.',
    ]);

    $product2 = $stripe->products->create([
        'name' => 'Maglietta personalizzata',
        'description' => 'Una maglietta personalizzata con il tuo logo o design.',
    ]);

    // Creazione di prezzi per i prodotti
    $price1 = $stripe->prices->create([
        'unit_amount' => 1500, // Il prezzo è in centesimi (1500 centesimi = $15.00 USD)
        'currency' => 'usd',
        'product' => $product1->id,
    ]);

    $price2 = $stripe->prices->create([
        'unit_amount' => 2000, // Ad esempio, un'altra tariffa
        'currency' => 'usd',
        'product' => $product2->id,
    ]);

    // Creazione di una sessione di pagamento
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [
            [
                'price' => $price1->id,
                'quantity' => 1,
            ],
            [
                'price' => $price2->id,
                'quantity' => 1,
            ],
        ],
        'mode' => 'payment',
        'success_url' => 'https://example.com/success',
        'cancel_url' => 'https://example.com/cancel',
    ]);

    return response()->json([
        'data' => $session
    ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
