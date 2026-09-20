<?php

namespace App\Mail;

use App\Models\Mensagem;
use App\Models\Imovel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DisponibilidadeNotificada extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Mensagem $mensagem,
        public Imovel $imovel,
        public bool $disponivel
    ) {}

    public function build(): Mailable
    {
        $assunto = $this->disponivel
            ? 'Imóvel Disponível — QNB Imobiliária'
            : 'Imóvel Indisponível — QNB Imobiliária';

        return $this
            ->subject($assunto)
            ->markdown('emails.disponibilidade-notificada');
    }
}
