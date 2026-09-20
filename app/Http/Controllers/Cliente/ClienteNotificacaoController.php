<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;

class ClienteNotificacaoController extends Controller
{
    public function index()
    {
        $cliente = auth()->guard('cliente')->user();

        $notificacoes = $cliente->notificacoes()
            ->latest()
            ->orderBy('lida')
            ->get();

        $naoLidas = $cliente->notificacoes()->naoLidas()->count();

        return view('cliente.notificacoes', compact('notificacoes', 'naoLidas'));
    }

    public function ler($id)
    {
        $cliente = auth()->guard('cliente')->user();

        $notificacao = $cliente->notificacoes()->findOrFail($id);
        $notificacao->marcarComoLida();

        return back()->with('sucesso', 'Notificação marcada como lida.');
    }

    public function lerTodas()
    {
        $cliente = auth()->guard('cliente')->user();

        $cliente->notificacoes()->naoLidas()->update([
            'lida' => true,
            'lida_em' => now(),
        ]);

        return back()->with('sucesso', 'Todas as notificações foram marcadas como lidas.');
    }
}
