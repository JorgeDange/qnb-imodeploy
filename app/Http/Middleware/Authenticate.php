<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if ($request->is('admin/*') || $request->routeIs('admin.*')) {
            return route('admin.login');
        }
        if ($request->is('cliente/*') || $request->routeIs('cliente.*')) {
            return route('cliente.login');
        }
        return route('painel.login');
    }

    protected function unauthenticated($request, array $guards)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Sessão expirada.'], 401);
        }

        $guard = $guards[0] ?? null;
        $redirectUrl = $this->redirectTo($request);

        $flashKey = match($guard) {
            'admin' => 'error',
            'cliente' => 'error',
            default => 'error',
        };

        return redirect($redirectUrl)->with($flashKey, 'Sessão expirada. Faça login novamente.');
    }
}
