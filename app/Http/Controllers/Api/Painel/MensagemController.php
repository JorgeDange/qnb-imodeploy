<?php

namespace App\Http\Controllers\Api\Painel;

use App\Http\Controllers\Controller;
use App\Models\Mensagem;
use Illuminate\Http\Request;

class MensagemController extends Controller
{
    public function index(Request $request)
    {
        $mensagens = $request->user()->mensagens()
            ->with('imovel:id,referencia,titulo')
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'mensagens' => $mensagens,
            'nao_lidas' => $mensagens->where('lida', false)->count(),
        ]);
    }

    public function marcarLida(Request $request, Mensagem $mensagem)
    {
        abort_unless($mensagem->imobiliaria_id === $request->user()->id, 403, 'Sem permissão.');
        $mensagem->update(['lida' => true]);

        return response()->json(['mensagem' => 'Marcada como lida.', 'lida' => true]);
    }
}
