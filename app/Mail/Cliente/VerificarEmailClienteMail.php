<?php

namespace App\Mail\Cliente;

use App\Models\Cliente;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificarEmailClienteMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Cliente $cliente, public string $token) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Confirma o teu email — QNB-Imobiliária');
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.cliente.verificar-email',
            with: [
                'url' => config('app.frontend_url', 'http://localhost:8080')
                    . '/cliente/verificar-email.html?token=' . $this->token,
            ],
        );
    }
}
