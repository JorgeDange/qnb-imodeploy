<?php

namespace App\Observers;

use App\Models\Imobiliaria;
use App\Services\ActivityLogService;

class ImobiliariaObserver
{
    public function created(Imobiliaria $imobiliaria): void
    {
        ActivityLogService::log('criar_imobiliaria', $imobiliaria, $imobiliaria->toArray());
    }

    public function updated(Imobiliaria $imobiliaria): void
    {
        ActivityLogService::log('editar_imobiliaria', $imobiliaria, [
            'antes' => $imobiliaria->getOriginal(),
            'depois' => $imobiliaria->getChanges(),
        ]);
    }

    public function deleted(Imobiliaria $imobiliaria): void
    {
        ActivityLogService::log('apagar_imobiliaria', $imobiliaria, $imobiliaria->toArray());
    }
}
