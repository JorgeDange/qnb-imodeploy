<?php

namespace App\Http\Controllers\Api\Painel;

use App\Http\Controllers\Controller;
use App\Jobs\SendPedidoAtivacaoEmail;
use App\Models\PedidoAtivacao;
use App\Models\Plano;
use Illuminate\Http\Request;

class PlanoController extends Controller
{
    public function resumo(Request $request)
    {
        $imobiliaria = $request->user();
        $ativo = $imobiliaria->getPlanoAtivo();

        return response()->json([
            'estado' => $imobiliaria->estadoAtual(),
            'plano' => $ativo ? [
                'nome' => $ativo->plano->nome,
                'posts_limite' => $ativo->plano->posts_limite,
                'posts_usados' => $ativo->posts_usados,
                'posts_restantes' => max(0, $ativo->plano->posts_limite - $ativo->posts_usados),
                'data_expiracao' => $ativo->data_expiracao?->toDateString(),
                'dias_restantes' => $ativo->diasRestantes(),
            ] : null,
            'planos_disponiveis' => Plano::where('ativo', true)->orderBy('preco')->get(),
        ]);
    }

    public function pedido(Request $request)
    {
        $validados = $request->validate([
            'plano_pretendido' => ['nullable', 'string', 'max:255'],
            'mensagem' => ['nullable', 'string', 'max:1000'],
        ]);

        $pedido = PedidoAtivacao::create([
            'imobiliaria_id' => $request->user()->id,
            'plano_pretendido' => $validados['plano_pretendido'] ?? null,
            'mensagem' => $validados['mensagem'] ?? null,
            'estado' => 'novo',
        ]);

        SendPedidoAtivacaoEmail::dispatch($pedido);

        return response()->json([
            'mensagem' => 'Pedido registado. A equipa QNB entrará em contacto.',
            'pedido' => $pedido,
        ], 201);
    }
}
