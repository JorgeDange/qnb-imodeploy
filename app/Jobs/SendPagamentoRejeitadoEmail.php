<?php

namespace App\Jobs;

use App\Mail\PagamentoRejeitado;
use App\Models\Pagamento;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPagamentoRejeitadoEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Pagamento $pagamento
    ) {}

    public function handle(): void
    {
        Mail::to($this->pagamento->imobiliaria->email)
            ->send(new PagamentoRejeitado($this->pagamento));
    }
}
