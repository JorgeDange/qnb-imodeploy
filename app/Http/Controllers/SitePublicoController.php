<?php

namespace App\Http\Controllers;

use App\Models\Imovel;
use App\Models\Depoimento;
use App\Models\Parceiro;
use App\Models\Setting;
use App\Models\Mensagem;
use App\Services\Cliente\InteracaoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SitePublicoController extends Controller
{
    public function imoveis(Request $request)
    {
        $query = Imovel::where('estado', 'aprovado')
            ->where('disponibilidade', 'disponivel')
            ->with('fotos');

        // Filtros
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('titulo', 'like', '%' . $request->keyword . '%')
                  ->orWhere('descricao', 'like', '%' . $request->keyword . '%')
                  ->orWhere('bairro', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('provincia')) {
            $query->where('provincia', $request->provincia);
        }

        if ($request->filled('finalidade')) {
            $query->where('finalidade', $request->finalidade);
        }

        if ($request->filled('preco_min')) {
            $query->where('preco', '>=', $request->preco_min);
        }

        if ($request->filled('preco_max')) {
            $query->where('preco', '<=', $request->preco_max);
        }

        if ($request->filled('quartos')) {
            $query->where('quartos', '>=', $request->quartos);
        }

        $imoveis = $query->orderByDesc('created_at')->paginate(12);

        $settings = Setting::pluck('valor', 'chave')->toArray();

        return view('imoveis.index', compact('imoveis', 'settings'));
    }

    public function show($referencia)
    {
        $imovel = Imovel::where('referencia', $referencia)
            ->where('estado', 'aprovado')
            ->with(['fotos' => function ($q) {
                $q->orderBy('ordem');
            }, 'amenidades', 'canais', 'imobiliaria'])
            ->firstOrFail();

        // Incrementar visualizações
        $imovel->increment('visualizacoes');

        if (Auth::guard('cliente')->check()) {
            $cliente = Auth::guard('cliente')->user();
            InteracaoService::registar($cliente->id, 'visualizacao', $imovel->id, $imovel->imobiliaria_id);
        }

        $settings = Setting::pluck('valor', 'chave')->toArray();

        return view('imoveis.show', compact('imovel', 'settings'));
    }

    public function contacto()
    {
        $settings = Setting::pluck('valor', 'chave')->toArray();
        return view('contacto', compact('settings'));
    }

    public function contactoEnviar(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'apelido' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefone' => 'required|string|max:20',
            'assunto' => 'required|string|max:255',
            'mensagem' => 'required|string|max:2000',
        ]);

        $texto = "Assunto: {$validated['assunto']}\n\n{$validated['mensagem']}";
        $contacto = "{$validated['telefone']} | {$validated['email']}";

        Mensagem::create([
            'nome' => "{$validated['nome']} {$validated['apelido']}",
            'contacto' => $contacto,
            'texto' => $texto,
            'origem' => 'site',
            'lida' => false,
        ]);

        return redirect()->route('contacto')->with('success', 'Mensagem enviada com sucesso! Entraremos em contacto brevemente.');
    }

    public function sobre()
    {
        $depoimentos = Depoimento::where('ativo', true)->get();
        $parceiros = Parceiro::orderBy('ordem')->get();

        $estatisticas = [
            'imoveis' => Imovel::where('estado', 'aprovado')->where('disponibilidade', 'disponivel')->count(),
            'imobiliarias' => \App\Models\Imobiliaria::where('estado', 'aprovada')->count(),
            'interacoes' => Imovel::sum('contactos'),
        ];

        $settings = Setting::pluck('valor', 'chave')->toArray();

        return view('sobre', compact('depoimentos', 'parceiros', 'estatisticas', 'settings'));
    }

    public function comoFunciona()
    {
        $settings = Setting::pluck('valor', 'chave')->toArray();
        return view('como-funciona', compact('settings'));
    }
}
