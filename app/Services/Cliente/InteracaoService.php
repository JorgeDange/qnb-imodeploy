<?php

namespace App\Services\Cliente;

use App\Models\Interacao;
use Illuminate\Http\Request;

class InteracaoService
{
    public static function registar(
        int $clienteId,
        string $tipo,
        ?int $imovelId = null,
        ?int $imobiliariaId = null,
        array $metadados = []
    ): Interacao {
        $request = request();

        return Interacao::create([
            'cliente_id'     => $clienteId,
            'imovel_id'      => $imovelId,
            'imobiliaria_id' => $imobiliariaId,
            'tipo'           => $tipo,
            'metadados'      => $metadados ?: null,
            'ip_address'     => $request?->ip(),
            'user_agent'     => $request?->userAgent(),
            'created_at'     => now(),
        ]);
    }
}
