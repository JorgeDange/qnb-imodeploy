<?php

namespace App\Mail;

use App\Models\Imovel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ImovelSubmetido extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Imovel $imovel,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('mail.from.address'),
            subject: 'Imóvel Submetido para Aprovação',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.imovel-submetido',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
