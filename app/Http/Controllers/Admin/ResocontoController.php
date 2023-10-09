<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Stripe\Charge;
use Stripe\Issuing\Transaction;
use Stripe\Stripe as StripeGateway;
use Stripe\PaymentIntent;

class ResocontoController extends Controller
{
    protected function index (){
        StripeGateway::setApiKey(env('STRIPE_SECRET'));

        $successTransactions = Charge::all();
        // $stripe->paymentIntents->all();

        return Inertia::render('Dashboard/Resoconto/ResocontoIndex', [
            'transazioni' => $successTransactions
        ]);
    }
}
