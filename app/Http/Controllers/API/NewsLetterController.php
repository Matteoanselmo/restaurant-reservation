<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\NewsletterMail;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsLetterController extends Controller
{
    protected function sendNewsletter(Request $request)
    {
        $data = $request->all();
        $message = $data['message']['_value'];

        // // Recupera la lista delle email dei clienti da qualche parte
        $clientEmails = Client::pluck('email')->toArray();

        // // // Invia la newsletter a tutte le email dei clienti
        foreach ($clientEmails as $email) {
            Mail::to($email)->send(new NewsletterMail($message));
        }

        return response()->json(['message' => 'Newsletter inviata con successo']);

        //return response()->json(['data' => $data['message']['_value']]);
    }
}
