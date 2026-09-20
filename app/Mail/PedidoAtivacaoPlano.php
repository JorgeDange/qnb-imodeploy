<?php

namespace App\Mail;

use App\Models\PedidoAtivacao;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PedidoAtivacaoPlano extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public PedidoAtivacao $pedido,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('mail.from.address'),
            subject: 'Pedido de Ativação de Plano',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pedido-ativacao-plano',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
