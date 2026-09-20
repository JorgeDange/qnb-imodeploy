<?php

namespace App\Mail;

use App\Models\Imobiliaria;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NovaImobiliariaRegistada extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Imobiliaria $imobiliaria,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('mail.from.address'),
            subject: 'Nova Imobiliária Registada — Aprovação Pendente',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.nova-imobiliaria-registada',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
