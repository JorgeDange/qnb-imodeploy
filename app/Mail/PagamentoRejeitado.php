<?php

namespace App\Mail;

use App\Models\Pagamento;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PagamentoRejeitado extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Pagamento $pagamento,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('mail.from.address'),
            subject: 'Pagamento Rejeitado — QNB Imobiliária',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pagamento-rejeitado',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
