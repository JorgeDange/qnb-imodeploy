<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'conta.aprovada' => \App\Http\Middleware\EstadoConta::class,
            'plano.ativo' => \App\Http\Middleware\PlanoAtivo::class,
            'admin.auth' => \App\Http\Middleware\AdminAuth::class,
            'admin.role' => \App\Http\Middleware\EnsureAdminHasRole::class,
            'cliente.ativo' => \App\Http\Middleware\EnsureClienteAtivo::class,
        ]);

        $middleware->redirectGuestsTo(function ($request) {
            if ($request->is('admin/*') || $request->routeIs('admin.*')) {
                return route('admin.login');
            }
            if ($request->is('cliente/*') || $request->routeIs('cliente.*')) {
                return route('cliente.login');
            }
            return route('painel.login');
        });

        $middleware->redirectUsersTo('/painel');

        $middleware->trustProxies(at: '0.0.0.0/0');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
