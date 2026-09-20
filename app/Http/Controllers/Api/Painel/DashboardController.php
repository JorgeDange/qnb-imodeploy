<?php

namespace App\Http\Controllers\Api\Painel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $imobiliaria = $request->user();
        $imoveis = $imobiliaria->imoveis;

        $stats = [
            'total' => $imoveis->count(),
            'aprovados' => $imoveis->where('estado', 'aprovado')->count(),
            'pendentes' => $imoveis->where('estado', 'pendente')->count(),
            'rejeitados' => $imoveis->where('estado', 'rejeitado')->count(),
            'destaques' => $imoveis->where('destaque', true)->count(),
            'vistas' => $imoveis->sum('visualizacoes'),
            'contactos' => $imoveis->sum('contactos'),
            'nao_lidas' => $imobiliaria->mensagens()->where('lida', false)->count(),
        ];

        $maisVistos = $imoveis->sortByDesc('visualizacoes')->take(5)->values();
        $ultimasMensagens = $imobiliaria->mensagens()
            ->with('imovel:id,referencia,titulo')
            ->orderByDesc('created_at')
            ->take(4)
            ->get();

        return response()->json([
            'stats' => $stats,
            'mais_vistos' => $maisVistos,
            'ultimas_mensagens' => $ultimasMensagens,
            'estado_conta' => $imobiliaria->estadoAtual(),
        ]);
    }
}
