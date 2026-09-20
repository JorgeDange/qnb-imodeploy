<?php

namespace App\Providers;

use App\Models\Imobiliaria;
use App\Models\Imovel;
use App\Models\Plano;
use App\Observers\ImobiliariaObserver;
use App\Providers\View\Composers\AdminSidebarComposer;
use App\Observers\ImovelObserver;
use App\Observers\PlanoObserver;
use App\Providers\View\Composers\ClienteSidebarComposer;
use App\Providers\View\Composers\PainelSidebarComposer;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->environment('production') && request()->header('HTTP_X_FORWARDED_PROTO') === 'https') {
            URL::forceScheme('https');
        }

        RateLimiter::for('admin-login', function (Request $request) {
            return Limit::perMinute(5)->by($request->input('email') . '|' . $request->ip());
        });

        Plano::observe(PlanoObserver::class);
        Imobiliaria::observe(ImobiliariaObserver::class);
        Imovel::observe(ImovelObserver::class);

        View::composer(
            ['cliente.*', 'cliente.auth.*'],
            ClienteSidebarComposer::class
        );

        View::composer(
            'admin.*',
            AdminSidebarComposer::class
        );

        View::composer(
            'layouts.painel',
            PainelSidebarComposer::class
        );
    }
}
