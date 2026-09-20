<?php

namespace App\Jobs;

use App\Mail\DisponibilidadeNotificada;
use App\Models\Imovel;
use App\Models\Mensagem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendDisponibilidadeNotificadaEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Mensagem $mensagem,
        public Imovel $imovel,
        public bool $disponivel
    ) {}

    public function handle(): void
    {
        $email = $this->mensagem->contacto;

        if ($email && str_contains($email, '@')) {
            Mail::to($email)->send(
                new DisponibilidadeNotificada($this->mensagem, $this->imovel, $this->disponivel)
            );
        }
    }
}
