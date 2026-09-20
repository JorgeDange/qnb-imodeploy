<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureClienteAtivo
{
    public function handle(Request $request, Closure $next): Response
    {
        $cliente = $request->user();

        if (!$cliente) {
            return redirect()->route('cliente.login')
                ->with('error', 'Sessão expirada. Faça login novamente.');
        }

        if (!$cliente->estaAtivo()) {
            auth()->guard('cliente')->logout();

            return redirect()->route('cliente.login')
                ->with('error', 'A tua conta não está ativa.');
        }

        return $next($request);
    }
}
