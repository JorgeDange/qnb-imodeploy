<?php

namespace App\Jobs;

use App\Mail\PagamentoRecebido;
use App\Models\Pagamento;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPagamentoRecebidoEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Pagamento $pagamento
    ) {}

    public function handle(): void
    {
        $adminEmail = config('mail.admin_notification_email', config('mail.from.address'));
        Mail::to($adminEmail)->send(new PagamentoRecebido($this->pagamento));
    }
}
