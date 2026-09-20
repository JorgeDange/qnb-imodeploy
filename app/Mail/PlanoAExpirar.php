<?php

namespace App\Mail;

use App\Models\ImobiliariaPlano;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PlanoAExpirar extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ImobiliariaPlano $assinatura,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('mail.from.address'),
            subject: 'O seu plano está a expirar — QNB Imobiliária',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.plano-a-expirar',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
