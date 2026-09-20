<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientePesquisaController extends Controller
{
    public function index()
    {
        $pesquisas = auth()->guard('cliente')->user()
            ->pesquisas()
            ->latest()
            ->get();

        return view('cliente.pesquisas', compact('pesquisas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'termo' => 'required|string|max:255',
        ]);

        $cliente = auth()->guard('cliente')->user();

        // C8 fix: duplicado → erro de validação (não exceção 500)
        $existe = $cliente->pesquisas()
            ->where('termo', $validated['termo'])
            ->exists();

        if ($existe) {
            return back()->withErrors([
                'termo' => 'Já tem uma pesquisa guardada com este termo.',
            ]);
        }

        $cliente->pesquisas()->create([
            'termo' => $validated['termo'],
        ]);

        return back()->with('sucesso', 'Pesquisa guardada!');
    }

    public function destroy($pesquisa)
    {
        $pesquisa = auth()->guard('cliente')->user()->pesquisas()->findOrFail($pesquisa);
        $pesquisa->delete();

        return back()->with('sucesso', 'Pesquisa removida!');
    }
}
