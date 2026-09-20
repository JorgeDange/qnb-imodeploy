<?php

namespace App\Jobs;

use App\Mail\ImovelSubmetido;
use App\Models\Imovel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendImovelSubmetidoEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Imovel $imovel
    ) {}

    public function handle(): void
    {
        $adminEmail = config('mail.admin_notification_email', config('mail.from.address'));
        Mail::to($adminEmail)->send(new ImovelSubmetido($this->imovel));
    }
}
