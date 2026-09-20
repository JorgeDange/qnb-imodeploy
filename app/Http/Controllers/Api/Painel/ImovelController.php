<?php

namespace App\Http\Controllers\Api\Painel;

use App\Http\Controllers\Controller;
use App\Jobs\SendImovelSubmetidoEmail;
use App\Models\Imovel;
use Illuminate\Http\Request;

class ImovelController extends Controller
{
    private function proximaReferencia(): string
    {
        $max = Imovel::where('referencia', 'like', '#QNB-%')
            ->selectRaw('MAX(CAST(SUBSTRING(referencia, 6) AS UNSIGNED)) as max_ref')
            ->value('max_ref');
        $num = ((int) $max) + 1;
        return '#QNB-' . str_pad((string) $num, 3, '0', STR_PAD_LEFT);
    }

    public function index(Request $request)
    {
        $imoveis = $request->user()->imoveis()
            ->with('fotos')
            ->orderByDesc('created_at')
            ->get();

        return response()->json(['imoveis' => $imoveis]);
    }

    public function store(Request $request)
    {
        $imobiliaria = $request->user();
        $plano = $imobiliaria->getPlanoAtivo();
        if (!$plano) {
            return response()->json(['mensagem' => 'É necessário um plano ativo.'], 403);
        }
        if ($plano->posts_usados >= $plano->plano->posts_limite) {
            return response()->json(['mensagem' => 'Limite de anúncios do plano atingido.'], 403);
        }

        $validados = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'tipo' => ['required', 'in:apartamento,vivenda,terreno,loja,escritorio,armazem,quintal'],
            'finalidade' => ['required', 'in:arrendar,comprar,vender'],
            'preco' => ['required', 'numeric', 'min:0'],
            'moeda' => ['required', 'in:Kz,USD'],
            'area' => ['nullable', 'numeric', 'min:0'],
            'quartos' => ['nullable', 'integer', 'min:0'],
            'wc' => ['nullable', 'integer', 'min:0'],
            'ano_construcao' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
            'video' => ['nullable', 'url', 'max:500'],
            'provincia' => ['required', 'string', 'max:100'],
            'municipio' => ['required', 'string', 'max:100'],
            'bairro' => ['nullable', 'string', 'max:150'],
            'endereco' => ['nullable', 'string', 'max:255'],
            'descricao' => ['required', 'string', 'min:20'],
            'fotos' => ['required', 'array', 'min:5', 'max:20'],
            'fotos.*' => ['image', 'mimes:jpeg,png,webp', 'max:5120'],
            'amenidades' => ['nullable', 'array'],
            'amenidades.*' => ['integer', 'exists:amenidades,id'],
        ]);

        $imovel = $imobiliaria->imoveis()->create([
            'referencia' => $this->proximaReferencia(),
            'estado' => 'pendente',
            'disponibilidade' => 'disponivel',
        ] + $validados);

        $ordem = 0;
        foreach ($request->file('fotos') as $foto) {
            $caminho = $foto->store('imoveis/' . $imovel->id, 'public');
            $imovel->fotos()->create([
                'caminho' => $caminho,
                'ordem' => $ordem,
                'capa' => $ordem === 0,
            ]);
            $ordem++;
        }

        if (!empty($validados['amenidades'])) {
            $imovel->amenidades()->sync($validados['amenidades']);
        }

        $this->sincronizarCanais($request, $imovel);

        $plano->increment('posts_usados');

        SendImovelSubmetidoEmail::dispatch($imovel);

        return response()->json([
            'mensagem' => 'Anúncio criado. Aguarda aprovação da equipa QNB.',
            'imovel' => $imovel->load('fotos', 'amenidades'),
        ], 201);
    }

    public function show(Request $request, Imovel $imovel)
    {
        $this->authorizar($request, $imovel);
        return response()->json(['imovel' => $imovel->load('fotos', 'amenidades', 'canais')]);
    }

    public function update(Request $request, Imovel $imovel)
    {
        $this->authorizar($request, $imovel);
        if (!$request->user()->getPlanoAtivo()) {
            return response()->json(['mensagem' => 'É necessário um plano ativo.'], 403);
        }

        $validados = $request->validate([
            'titulo' => ['sometimes', 'string', 'max:255'],
            'tipo' => ['sometimes', 'in:apartamento,vivenda,terreno,loja,escritorio,armazem,quintal'],
            'finalidade' => ['sometimes', 'in:arrendar,comprar,vender'],
            'preco' => ['sometimes', 'numeric', 'min:0'],
            'moeda' => ['sometimes', 'in:Kz,USD'],
            'area' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'quartos' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'wc' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'ano_construcao' => ['sometimes', 'nullable', 'integer', 'min:1900', 'max:' . date('Y')],
            'video' => ['sometimes', 'nullable', 'url', 'max:500'],
            'provincia' => ['sometimes', 'string', 'max:100'],
            'municipio' => ['sometimes', 'string', 'max:100'],
            'bairro' => ['sometimes', 'nullable', 'string', 'max:150'],
            'endereco' => ['sometimes', 'nullable', 'string', 'max:255'],
            'descricao' => ['sometimes', 'string', 'min:20'],
            'disponibilidade' => ['sometimes', 'in:disponivel,vendido,arrendado'],
            'fotos' => ['sometimes', 'array', 'min:1', 'max:20'],
            'fotos.*' => ['image', 'mimes:jpeg,png,webp', 'max:5120'],
            'amenidades' => ['sometimes', 'array'],
            'amenidades.*' => ['integer', 'exists:amenidades,id'],
        ]);

        unset($validados['fotos']);
        $imovel->update($validados);

        if ($request->hasFile('fotos')) {
            $ordem = $imovel->fotos()->count();
            foreach ($request->file('fotos') as $foto) {
                $caminho = $foto->store('imoveis/' . $imovel->id, 'public');
                $imovel->fotos()->create([
                    'caminho' => $caminho,
                    'ordem' => $ordem,
                    'capa' => $ordem === 0,
                ]);
                $ordem++;
            }
        }

        if ($request->has('amenidades')) {
            $imovel->amenidades()->sync($request->input('amenidades', []));
        }

        $this->sincronizarCanais($request, $imovel);

        return response()->json([
            'mensagem' => 'Anúncio atualizado.',
            'imovel' => $imovel->load('fotos', 'amenidades', 'canais'),
        ]);
    }

    public function destroy(Request $request, Imovel $imovel)
    {
        $this->authorizar($request, $imovel);
        $imovel->delete();

        if ($plano = $request->user()->getPlanoAtivo()) {
            $plano->decrement('posts_usados');
        }

        return response()->json(['mensagem' => 'Anúncio removido.']);
    }

    public function destaque(Request $request, Imovel $imovel)
    {
        $this->authorizar($request, $imovel);
        if ($imovel->estado !== 'aprovado') {
            return response()->json(['mensagem' => 'Apenas anúncios aprovados podem ser destacados.'], 422);
        }
        $imovel->update(['destaque' => !$imovel->destaque]);

        return response()->json([
            'mensagem' => $imovel->destaque ? 'Anúncio destacado.' : 'Destaque removido.',
            'destaque' => $imovel->destaque,
        ]);
    }

    private function sincronizarCanais(Request $request, Imovel $imovel): void
    {
        if (!$request->has('canais')) {
            return;
        }

        $permitidos = ['whatsapp', 'telefone', 'email', 'facebook', 'instagram', 'linkedin'];
        $imovel->canais()->delete();

        foreach ($request->input('canais', []) as $canal) {
            if (empty($canal['tipo']) || empty($canal['valor']) || !in_array($canal['tipo'], $permitidos, true)) {
                continue;
            }
            $imovel->canais()->create([
                'tipo' => $canal['tipo'],
                'valor' => trim($canal['valor']),
            ]);
        }
    }

    private function authorizar(Request $request, Imovel $imovel): void
    {
        abort_unless($imovel->imobiliaria_id === $request->user()->id, 403, 'Sem permissão.');
    }
}
