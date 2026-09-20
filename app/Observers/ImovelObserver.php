<?php

namespace App\Observers;

use App\Models\Imovel;
use App\Services\ActivityLogService;

class ImovelObserver
{
    public function created(Imovel $imovel): void
    {
        ActivityLogService::log('criar_imovel', $imovel, $imovel->toArray());
    }

    public function updated(Imovel $imovel): void
    {
        ActivityLogService::log('editar_imovel', $imovel, [
            'antes' => $imovel->getOriginal(),
            'depois' => $imovel->getChanges(),
        ]);
    }

    public function deleted(Imovel $imovel): void
    {
        ActivityLogService::log('apagar_imovel', $imovel, $imovel->toArray());
    }
}
