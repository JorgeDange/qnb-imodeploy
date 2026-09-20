<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Imovel;
use App\Models\ClienteFavorito;
use App\Services\Cliente\InteracaoService;
use Illuminate\Http\Request;

class ClienteFavoritoController extends Controller
{
    public function index()
    {
        $favoritos = auth()->guard('cliente')->user()
            ->favoritos()
            ->with('imovel')
            ->get();

        return view('cliente.favoritos', compact('favoritos'));
    }

    public function store(Imovel $imovel, Request $request)
    {
        $cliente = auth()->guard('cliente')->user();

        $existe = ClienteFavorito::where('cliente_id', $cliente->id)
            ->where('imovel_id', $imovel->id)
            ->first();

        if ($existe) {
            return back()
                ->with('error', 'Este imóvel já está nos seus favoritos.');
        }

        ClienteFavorito::create([
            'cliente_id' => $cliente->id,
            'imovel_id' => $imovel->id,
        ]);

        InteracaoService::registar($cliente->id, 'favorito_adicionado', $imovel->id, $imovel->imobiliaria_id);

        return back()
            ->with('sucesso', 'Imóvel adicionado aos favoritos!');
    }

    public function destroy(Imovel $imovel)
    {
        $cliente = auth()->guard('cliente')->user();

        $favorito = ClienteFavorito::where('cliente_id', $cliente->id)
            ->where('imovel_id', $imovel->id)
            ->firstOrFail();

        $favorito->delete();

        return back()
            ->with('sucesso', 'Imóvel removido dos favoritos!');
    }
}
