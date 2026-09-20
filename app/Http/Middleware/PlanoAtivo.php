<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PlanoAtivo
{
    public function handle(Request $request, Closure $next): Response
    {
        $imobiliaria = $request->user();

        if (!$imobiliaria || !$imobiliaria->getPlanoAtivo()) {
            return redirect()->route('painel.ativar-plano')
                ->with('error', 'É necessário um plano ativo para esta ação.');
        }

        return $next($request);
    }
}
