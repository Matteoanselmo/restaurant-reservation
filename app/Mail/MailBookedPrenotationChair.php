<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailBookedPrenotationChair extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // Dati da passare alla vista Blade dell'email

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Prenotazione Posto Villa Albertina',
        );
    }

    public function build()
    {
        return $this->subject('Prenotazione Posto Villa Albertina')
            ->view('emails.BookedPrenotationChair')
            ->with(['data' => $this->data]); // Specifica il nome della vista Blade per il contenuto dell'email
    }

}
