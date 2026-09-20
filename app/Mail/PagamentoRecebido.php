<?php

namespace App\Mail;

use App\Models\Pagamento;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PagamentoRecebido extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Pagamento $pagamento,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('mail.from.address'),
            subject: 'Novo Pagamento Recebido — QNB Imobiliária',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pagamento-recebido',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
