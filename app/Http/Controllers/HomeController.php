<?php

namespace App\Http\Controllers;

use App\Models\Imovel;
use App\Models\Imobiliaria;
use App\Models\Setting;
use App\Models\Depoimento;
use App\Models\Parceiro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Cidades com contagem de imóveis aprovados
        $cidades = Imovel::where('estado', 'aprovado')
            ->where('disponibilidade', 'disponivel')
            ->select('provincia', DB::raw('count(*) as total'))
            ->groupBy('provincia')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        // Imóveis em destaque
        $imoveisDestaque = Imovel::where('estado', 'aprovado')
            ->where('disponibilidade', 'disponivel')
            ->where('destaque', true)
            ->with('fotos')
            ->limit(6)
            ->get();

        // Imóveis recentes para sidebar
        $imoveisRecentes = Imovel::where('estado', 'aprovado')
            ->where('disponibilidade', 'disponivel')
            ->with('fotos')
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        // Estatísticas
        $estatisticas = [
            'imoveis' => Imovel::where('estado', 'aprovado')->where('disponibilidade', 'disponivel')->count(),
            'imobiliarias' => Imobiliaria::where('estado', 'aprovada')->count(),
            'interacoes' => Imovel::sum('contactos'),
            'provincias' => Imovel::where('estado', 'aprovado')->distinct('provincia')->count('provincia'),
        ];

        // Settings
        $settings = Setting::pluck('valor', 'chave')->toArray();

        // Depoimentos
        $depoimentos = Depoimento::where('ativo', true)->orderBy('ordem')->get();

        // Parceiros
        $parceiros = Parceiro::where('ativo', true)->orderBy('ordem')->get();

        return view('welcome', compact('cidades', 'imoveisDestaque', 'imoveisRecentes', 'estatisticas', 'settings', 'depoimentos', 'parceiros'));
    }
}
