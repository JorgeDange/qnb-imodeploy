<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Imovel;
use App\Models\Mensagem;
use App\Services\Cliente\InteracaoService;
use Illuminate\Http\Request;

class ClienteMensagemController extends Controller
{
    public function index()
    {
        $mensagens = auth()->guard('cliente')->user()
            ->mensagens()
            ->latest()
            ->get();

        return view('cliente.mensagens', compact('mensagens'));
    }

    public function show(Mensagem $mensagem)
    {
        return view('cliente.ver-mensagem', compact('mensagem'));
    }

    public function responder(Request $request, Mensagem $mensagem)
    {
        $validated = $request->validate([
            'texto' => 'required|string',
        ]);

        $mensagem->responder($validated['texto']);

        return back()
            ->with('sucesso', 'Resposta enviada!');
    }

    public function enviar(Request $request, $imovel_id)
    {
        $validated = $request->validate([
            'texto' => 'required|string',
            'tipo' => 'sometimes|string',
        ]);

        $cliente = auth()->guard('cliente')->user();
        $imovel = Imovel::findOrFail($imovel_id);

        $mensagem = Mensagem::create([
            'imobiliaria_id' => $imovel->imobiliaria_id,
            'cliente_id' => $cliente->id,
            'imovel_id' => $imovel_id,
            'nome' => $cliente->nome,
            'contacto' => $cliente->telefone,
            'texto' => $validated['texto'],
            'origem' => 'cliente',
        ]);

        InteracaoService::registar($cliente->id, 'mensagem_enviada', $imovel_id, $imovel->imobiliaria_id);

        return back()
            ->with('sucesso', 'Mensagem enviada com sucesso!');
    }
}
