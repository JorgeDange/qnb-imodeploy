<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Imovel;
use Illuminate\Http\Request;

class ImovelPublicoController extends Controller
{
    public function index(Request $request)
    {
        $q = Imovel::with(['fotos', 'imobiliaria'])
            ->where('estado', 'aprovado')
            ->where('disponibilidade', 'disponivel');

        if ($request->has('finalidade')) {
            $q->where('finalidade', $request->query('finalidade'));
        }
        if ($request->has('tipo')) {
            $q->where('tipo', $request->query('tipo'));
        }
        if ($request->has('provincia')) {
            $q->where('provincia', $request->query('provincia'));
        }
        if ($request->has('municipio')) {
            $q->where('municipio', $request->query('municipio'));
        }
        if ($request->has('quartos')) {
            $q->where('quartos', (int) $request->query('quartos'));
        }
        if ($request->has('preco_min')) {
            $q->where('preco', '>=', (float) $request->query('preco_min'));
        }
        if ($request->has('preco_max')) {
            $q->where('preco', '<=', (float) $request->query('preco_max'));
        }
        if ($request->has('palavra') && trim($request->query('palavra')) !== '') {
            $busca = '%' . trim($request->query('palavra')) . '%';
            $q->where(function ($w) use ($busca) {
                $w->where('titulo', 'like', $busca)
                    ->orWhere('bairro', 'like', $busca)
                    ->orWhere('municipio', 'like', $busca)
                    ->orWhere('provincia', 'like', $busca);
            });
        }
        if ($request->has('destacados') && $request->boolean('destacados')) {
            $q->where('destaque', true);
        }

        $ordem = $request->query('ordem', 'recentes');
        if ($ordem === 'preco_asc') {
            $q->orderBy('preco');
        } elseif ($ordem === 'preco_desc') {
            $q->orderByDesc('preco');
        } else {
            $q->latest();
        }

        return response()->json([
            'imoveis' => $q->paginate((int) $request->query('por_pagina', 9)),
        ]);
    }

    public function show(Request $request, Imovel $imovel)
    {
        if ($imovel->estado !== 'aprovado') {
            return response()->json(['mensagem' => 'Imóvel não disponível.'], 404);
        }

        $imovel->increment('visualizacoes');
        $imovel->load(['fotos', 'amenidades', 'imobiliaria', 'canais']);

        return response()->json(['imovel' => $imovel]);
    }
}
