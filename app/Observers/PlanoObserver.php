<?php

namespace App\Observers;

use App\Models\Plano;
use App\Services\ActivityLogService;

class PlanoObserver
{
    public function created(Plano $plano): void
    {
        ActivityLogService::log('criar_plano', $plano, $plano->toArray());
    }

    public function updated(Plano $plano): void
    {
        ActivityLogService::log('editar_plano', $plano, [
            'antes' => $plano->getOriginal(),
            'depois' => $plano->getChanges(),
        ]);
    }

    public function deleted(Plano $plano): void
    {
        ActivityLogService::log('apagar_plano', $plano, $plano->toArray());
    }
}
