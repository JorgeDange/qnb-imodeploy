<?php

namespace App\Actions\Planos;

use App\Models\Plano;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\DB;

class CriarPlanoAction
{
    public function execute(array $dados): Plano
    {
        return DB::transaction(function () use ($dados) {
            $plano = Plano::create($dados);
            ActivityLogService::log('criar_plano', $plano, $dados);
            return $plano;
        });
    }
}
