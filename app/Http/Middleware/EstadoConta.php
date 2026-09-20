<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EstadoConta
{
    public function handle(Request $request, Closure $next): Response
    {
        $imobiliaria = $request->user();

        if (!$imobiliaria) {
            return redirect()->route('painel.login')
                ->with('error', 'Não autenticado.');
        }

        if ($imobiliaria->estado === 'pendente') {
            Auth::guard('imobiliaria')->logout();
            return redirect()->route('painel.login')
                ->with('error', 'A sua conta aguarda aprovação da equipa QNB.');
        }

        return $next($request);
    }
}
