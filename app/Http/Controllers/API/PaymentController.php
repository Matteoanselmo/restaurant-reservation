<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Stripe;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function index(Request $request)
    {
        // Verifica che la richiesta contenga dati validi

        // if (!isset($requestData['prenotations']) || empty($requestData['prenotations'])) {
        //     return response()->json(['error' => 'Dati delle prenotazioni non validi'], 400);
        // }

        $prenotations = $request->input('prenotations');
        $results = [];
        foreach ($prenotations as $prenotation) {
                    // Estrarre i dati dalla stringa JSON
                    $prenotationData = json_decode($prenotation, true);

                    // Esempio: accedere ai dati
                    $n_posto = $prenotationData['n_posto'];
                    $nome = $prenotationData['nome'];
                    $cognome = $prenotationData['cognome'];
                    $n_telefono = $prenotationData['n_telefono'];
                    $price = $prenotationData['price'];

                    // Aggiungere i dati al risultato
                    $results[] = [
                        'n_posto' => $n_posto,
                        'nome' => $nome,
                        'cognome' => $cognome,
                        'n_telefono' => $n_telefono,
                        'price' => $price
                    ];
                }
        if (empty($results)) {
            return response()->json(['error' => 'Dati delle prenotazioni non validi'], 400);
        }

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        // Inizializza Stripe con la chiave segreta
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        // Crea prodotti e prezzi basati sui dati delle prenotazioni
        $lineItems = [];
        foreach ($results as $prenotationData) {
            // Assicurati di avere i dati necessari per creare un prodotto e un prezzo per ciascuna prenotazione
            if (!isset($prenotationData['nome']) || !isset($prenotationData['cognome']) || !isset($prenotationData['price'])) {
                return response()->json(['error' => 'Dati delle prenotazioni non validi'], 400);
            }

            // Crea un nuovo prodotto con il titolo "Cena evento"
            $product = $stripe->products->create([
                'name' => 'Cena evento', // Titolo del prodotto
                'description' => $prenotationData['nome'] . ' ' . $prenotationData['cognome'], // Descrizione personalizzata
            ]);

            // Crea un nuovo prezzo per il prodotto con il prezzo unitario
            $price = $stripe->prices->create([
                'unit_amount' => $prenotationData['price'], // Converti il prezzo in centesimi
                'currency' => 'eur', // Valuta
                'product' => $product->id,
            ]);

            // Aggiungi l'elemento linea per la sessione di pagamento
            $lineItems[] = [
                'price' => $price->id,
                'quantity' => 1,
            ];
        }

        // Crea una sessione di pagamento
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => 'http://192.168.188.32:8000/grazie',
            'cancel_url' => 'http://192.168.188.32:8000/errore-pagamento',
        ]);

        return response()->json([
            'session' => $session
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
