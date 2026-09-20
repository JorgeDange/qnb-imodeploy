<?php

namespace App\Jobs;

use App\Mail\NovaImobiliariaRegistada;
use App\Models\Imobiliaria;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNovaImobiliariaEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Imobiliaria $imobiliaria
    ) {}

    public function handle(): void
    {
        $adminEmail = config('mail.admin_notification_email', config('mail.from.address'));
        Mail::to($adminEmail)->send(new NovaImobiliariaRegistada($this->imobiliaria));
    }
}
