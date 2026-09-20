<?php

namespace App\Jobs;

use App\Mail\NovaMensagemRecebida;
use App\Models\Mensagem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNovaMensagemEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Mensagem $mensagem
    ) {}

    public function handle(): void
    {
        $imobiliaria = $this->mensagem->imobiliaria;
        if ($imobiliaria) {
            Mail::to($imobiliaria->email)->send(new NovaMensagemRecebida($this->mensagem));
        }
    }
}
