<?php

namespace App\Mail;

use App\Models\Visita;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VisitaRecusada extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Visita $visita
    ) {}

    public function build(): Mailable
    {
        return $this
            ->subject('Visita Indisponível — QNB Imobiliária')
            ->markdown('emails.visita-recusada');
    }
}
