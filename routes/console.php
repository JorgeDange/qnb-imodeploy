<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Subscrições expiradas — diário
// Schedule::command('subscricoes:expirar')->daily();

// Purga de logs antigos — semanal
// Schedule::command('logs:purgar')->weekly();

// Relatórios agendados — hora em hora
// Schedule::command('relatorios:executar')->hourly();
