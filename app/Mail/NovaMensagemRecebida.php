<?php

namespace App\Mail;

use App\Models\Mensagem;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NovaMensagemRecebida extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Mensagem $mensagem,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('mail.from.address'),
            subject: 'Nova Mensagem Recebida',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.nova-mensagem-recebida',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
