<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Depoimento;
use App\Models\Imobiliaria;
use App\Models\Imovel;
use App\Models\Mensagem;
use App\Models\Parceiro;
use App\Models\Setting;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function destaques()
    {
        $imoveis = Imovel::with(['fotos', 'imobiliaria'])
            ->where('estado', 'aprovado')
            ->where('disponibilidade', 'disponivel')
            ->where('destaque', true)
            ->latest()
            ->take(8)
            ->get();

        return response()->json(['imoveis' => $imoveis]);
    }

    public function estatisticas()
    {
        return response()->json([
            'imoveis_anunciados' => Imovel::where('estado', 'aprovado')->count(),
            'imobiliarias' => Imobiliaria::where('estado', 'aprovada')->count(),
            'anuncios_verificados' => Imovel::where('estado', 'aprovado')->count(),
            'area_anunciada' => Imovel::where('estado', 'aprovado')->sum('area'),
            'cidades' => Imovel::where('estado', 'aprovado')
                ->selectRaw('provincia, municipio, count(*) as total')
                ->groupBy('provincia', 'municipio')
                ->orderByDesc('total')
                ->take(12)
                ->get(),
        ]);
    }

    public function cidades()
    {
        $cidades = Imovel::where('estado', 'aprovado')
            ->selectRaw('provincia, municipio, count(*) as total')
            ->groupBy('provincia', 'municipio')
            ->orderByDesc('total')
            ->get();

        return response()->json(['cidades' => $cidades]);
    }

    public function depoimentos()
    {
        return response()->json([
            'depoimentos' => Depoimento::where('ativo', true)->orderBy('ordem')->get(),
        ]);
    }

    public function parceiros()
    {
        return response()->json([
            'parceiros' => Parceiro::where('ativo', true)->orderBy('ordem')->get(),
        ]);
    }

    public function settings()
    {
        $chaves = ['telefone', 'email', 'endereco', 'whatsapp', 'facebook', 'instagram', 'linkedin', 'horario'];
        return response()->json([
            'settings' => Setting::whereIn('chave', $chaves)->pluck('valor', 'chave'),
        ]);
    }

    public function enviarMensagem(Request $request)
    {
        $validados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'contacto' => ['required', 'string', 'max:255'],
            'texto' => ['required', 'string'],
            'imovel_id' => ['nullable', 'exists:imoveis,id'],
            'origem' => ['required', 'in:imovel,institucional,plano'],
        ]);

        $imovel = $validados['imovel_id'] ?? null ? Imovel::find($validados['imovel_id']) : null;

        $dados = [
            'imobiliaria_id' => $imovel ? $imovel->imobiliaria_id : null,
            'imovel_id' => $validados['imovel_id'] ?? null,
            'nome' => $validados['nome'],
            'contacto' => $validados['contacto'],
            'texto' => $validados['texto'],
            'origem' => $validados['origem'],
            'lida' => false,
        ];

        if ($request->user('cliente')) {
            $dados['cliente_id'] = $request->user('cliente')->id;
        }

        $mensagem = Mensagem::create($dados);

        if ($imovel) {
            $imovel->increment('contactos');
        }

        return response()->json([
            'mensagem' => 'Mensagem enviada com sucesso.',
            'mensagem_id' => $mensagem->id,
        ], 201);
    }
}
