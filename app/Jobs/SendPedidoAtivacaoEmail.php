<?php

namespace App\Jobs;

use App\Mail\PedidoAtivacaoPlano;
use App\Models\PedidoAtivacao;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPedidoAtivacaoEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public PedidoAtivacao $pedido
    ) {}

    public function handle(): void
    {
        $adminEmail = config('mail.admin_notification_email', config('mail.from.address'));
        Mail::to($adminEmail)->send(new PedidoAtivacaoPlano($this->pedido));
    }
}
