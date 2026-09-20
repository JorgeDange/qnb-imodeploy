<?php

namespace App\Jobs;

use App\Mail\VisitaConfirmada;
use App\Models\Visita;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendVisitaConfirmadaEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Visita $visita
    ) {}

    public function handle(): void
    {
        $email = $this->visita->cliente_email;

        if ($email) {
            Mail::to($email)->send(new VisitaConfirmada($this->visita));
        }
    }
}
