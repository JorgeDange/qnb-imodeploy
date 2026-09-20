<?php

namespace App\Mail\Cliente;

use App\Models\Cliente;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecuperarPasswordClienteMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Cliente $cliente, public string $token) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Recuperar password — QNB-Imobiliária');
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.cliente.recuperar-password',
            with: [
                'url' => config('app.frontend_url', 'http://localhost:8080')
                    . '/cliente/redefinir-password.html?token=' . $this->token
                    . '&email=' . urlencode($this->cliente->email),
            ],
        );
    }
}
