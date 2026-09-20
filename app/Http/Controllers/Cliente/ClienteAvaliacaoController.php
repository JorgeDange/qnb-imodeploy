<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cliente\CriarAvaliacaoRequest;
use App\Models\Avaliacao;
use App\Models\Imovel;
use App\Services\Cliente\InteracaoService;

class ClienteAvaliacaoController extends Controller
{
    public function index()
    {
        $cliente = auth()->guard('cliente')->user();

        $avaliacoes = $cliente->avaliacoes()
            ->with('imovel')
            ->latest()
            ->get();

        // Imóveis aprovados para o formulário
        $imoveis = Imovel::where('estado', 'aprovado')
            ->orderBy('titulo')
            ->get(['id', 'titulo', 'referencia']);

        return view('cliente.avaliacoes', compact('avaliacoes', 'imoveis'));
    }

    public function store(CriarAvaliacaoRequest $request)
    {
        $cliente = auth()->guard('cliente')->user();

        $imovel = Imovel::approved()->findOrFail($request->input('imovel_id'));

        // C10: apenas 1 avaliação ativa (pendente ou aprovada) por imóvel
        $existe = Avaliacao::where('cliente_id', $cliente->id)
            ->where('imovel_id', $imovel->id)
            ->whereIn('estado', ['pendente', 'aprovada'])
            ->exists();

        if ($existe) {
            return back()->withErrors([
                'imovel_id' => 'Já tem uma avaliação para este imóvel.',
            ])->withInput();
        }

        $avaliacao = $imovel->avaliacoes()->create([
            'imobiliaria_id' => $imovel->imobiliaria_id,
            'cliente_id' => $cliente->id,
            'autor_nome' => $cliente->nome,
            'autor_email' => $cliente->email,
            'estrelas' => $request->input('estrelas'),
            'comentario' => $request->input('comentario'),
            'estado' => 'pendente',
        ]);

        InteracaoService::registar(
            $cliente->id,
            'avaliacao',
            $imovel->id,
            $imovel->imobiliaria_id
        );

        return redirect()->route('cliente.avaliacoes')
            ->with('sucesso', 'Avaliação enviada com sucesso! Será publicada após aprovação.');
    }

    public function reenviar(Avaliacao $avaliacao)
    {
        $cliente = auth()->guard('cliente')->user();

        // Ownership check
        if ($avaliacao->cliente_id !== $cliente->id) {
            abort(403, 'Não tem permissão para reenviar esta avaliação.');
        }

        if ($avaliacao->estado !== 'rejeitada') {
            return back()->with('error', 'Só avaliações rejeitadas podem ser reenviadas.');
        }

        // Recria como nova pendente (a rejeitada fica no histórico)
        Avaliacao::create([
            'imovel_id' => $avaliacao->imovel_id,
            'imobiliaria_id' => $avaliacao->imobiliaria_id,
            'cliente_id' => $cliente->id,
            'autor_nome' => $cliente->nome,
            'autor_email' => $cliente->email,
            'estrelas' => $avaliacao->estrelas,
            'comentario' => $avaliacao->comentario,
            'estado' => 'pendente',
        ]);

        return redirect()->route('cliente.avaliacoes')
            ->with('sucesso', 'Avaliação reenviada para análise.');
    }
}
