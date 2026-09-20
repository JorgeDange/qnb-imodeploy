<?php

namespace App\Providers\View\Composers;

use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;

class ClienteSidebarComposer
{
    public function compose($view)
    {
        if (Auth::guard('cliente')->check()) {
            $cliente = Auth::guard('cliente')->user();
            
            $view->with('cliente', $cliente);
            $view->with('total_favoritos', $cliente->favoritos()->count());
            $view->with('total_mensagens_nao_lidas', $cliente->mensagens()->where('lida', false)->count());
            $view->with('total_visitas', $cliente->visitas()->count());
        }
    }
}