<?php

namespace App\Mail;

use App\Models\Pagamento;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class PagamentoConfirmado extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Pagamento $pagamento,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('mail.from.address'),
            subject: 'Pagamento Confirmado — QNB Imobiliária',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pagamento-confirmado',
        );
    }

    public function attachments(): array
    {
        $fatura = $this->pagamento->fatura;

        if (!$fatura || !$fatura->pdf_path) {
            return [];
        }

        $caminhoCompleto = storage_path('app/public/' . $fatura->pdf_path);

        if (!file_exists($caminhoCompleto)) {
            return [];
        }

        return [
            Attachment::fromPath($caminhoCompleto)
                ->as('Fatura-' . str_replace('/', '-', $fatura->numero) . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
