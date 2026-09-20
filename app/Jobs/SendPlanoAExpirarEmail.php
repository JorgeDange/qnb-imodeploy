<?php

namespace App\Jobs;

use App\Mail\PlanoAExpirar;
use App\Models\ImobiliariaPlano;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPlanoAExpirarEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public ImobiliariaPlano $assinatura
    ) {}

    public function handle(): void
    {
        Mail::to($this->assinatura->imobiliaria->email)
            ->send(new PlanoAExpirar($this->assinatura));
    }
}
