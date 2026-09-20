<?php

namespace App\Providers\View\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PainelSidebarComposer
{
    /**
     * Partilha os badges de contagem usados no sidebar do painel do anunciante.
     * Antes eram calculados com @php inline no layout (queries duplicadas em
     * cada render); agora ficam num único ponto, como no AdminSidebarComposer.
     *
     * Cache de 60s por imobiliária: as contagens só mudam com ações da própria
     * imobiliária, pelo que um TTL curto é suficiente e evita 4 queries/request.
     */
    public function compose($view)
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();

        if (! $imobiliaria) {
            return;
        }

        $planoAtivo = $imobiliaria->getPlanoAtivo();

        $diasRestantes = ($planoAtivo && $planoAtivo->data_expiracao)
            ? (int) $planoAtivo->data_expiracao->diffInDays(now())
            : 0;

        // Cache por imobiliária — os dados são específicos de cada conta
        $contagens = Cache::remember(
            "painel.sidebar.contagens.{$imobiliaria->id}",
            60,
            function () use ($imobiliaria) {
                return [
                    'imoveisCount' => $imobiliaria->imoveis()->count(),
                    'destaquesCount' => $imobiliaria->imoveis()->where('destaque', true)->count(),
                    'msgsNaoLidas' => $imobiliaria->mensagens()->where('lida', false)->count(),
                    'visitasPend' => $imobiliaria->visitas()->where('estado', 'pendente')->count(),
                ];
            }
        );

        // planoAtivo e diasRestantes ficam fora da cache: dependem do momento
        // e o getPlanoAtivo() já é uma única query barata.
        $view->with($contagens + [
            'planoAtivo' => $planoAtivo,
            'diasRestantes' => $diasRestantes,
        ]);
    }
}
