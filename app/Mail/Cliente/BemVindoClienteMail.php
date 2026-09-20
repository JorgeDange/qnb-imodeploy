<?php

namespace App\Mail\Cliente;

use App\Models\Cliente;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BemVindoClienteMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Cliente $cliente) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Bem-vindo à QNB-Imobiliária');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.cliente.bem-vindo');
    }
}
