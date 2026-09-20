<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cliente\CriarDenunciaRequest;
use App\Models\Imovel;
use App\Services\Cliente\InteracaoService;

class ClienteDenunciaController extends Controller
{
    public function index()
    {
        $cliente = auth()->guard('cliente')->user();

        $denuncias = $cliente->denuncias()
            ->with('imovel')
            ->latest()
            ->get();

        // Imóveis aprovados para o formulário
        $imoveis = Imovel::where('estado', 'aprovado')
            ->orderBy('titulo')
            ->get(['id', 'titulo', 'referencia']);

        return view('cliente.denuncias', compact('denuncias', 'imoveis'));
    }

    public function store(CriarDenunciaRequest $request)
    {
        $cliente = auth()->guard('cliente')->user();

        $imovel = Imovel::approved()->findOrFail($request->input('imovel_id'));

        $denuncia = $imovel->denuncias()->create([
            'imobiliaria_id' => $imovel->imobiliaria_id,
            'cliente_id' => $cliente->id,
            'autor_nome' => $cliente->nome,
            'autor_email' => $cliente->email,
            'autor_telefone' => $cliente->telefone,
            'motivo' => $request->input('motivo'),
            'descricao' => $request->input('descricao'),
            'estado' => 'pendente',
        ]);

        InteracaoService::registar(
            $cliente->id,
            'denuncia',
            $imovel->id,
            $imovel->imobiliaria_id
        );

        return redirect()->route('cliente.denuncias')
            ->with('sucesso', 'Denúncia enviada com sucesso! A nossa equipa vai analisá-la.');
    }
}
