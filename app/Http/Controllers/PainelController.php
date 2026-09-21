<?php

namespace App\Http\Controllers;

use App\Models\Imobiliaria;
use App\Models\Plano;
use App\Models\ImobiliariaPlano;
use App\Models\PedidoAtivacao;
use App\Models\Setting;
use App\Models\Imovel;
use App\Models\AdminMensagem;
use App\Models\ImovelFoto;
use App\Models\CanalContacto;
use App\Jobs\SendNovaImobiliariaEmail;
use App\Jobs\SendPedidoAtivacaoEmail;
use App\Services\PagamentoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PainelController extends Controller
{
    // ==================== AUTH ====================

    public function login()
    {
        if (Auth::guard('imobiliaria')->check()) {
            return redirect()->route('painel.dashboard');
        }
        return view('painel.auth.login');
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if (Auth::guard('imobiliaria')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('painel.dashboard'));
        }

        return back()->withErrors(['email' => 'Email ou palavra-passe incorretos.'])->onlyInput('email');
    }

    public function registo()
    {
        if (Auth::guard('imobiliaria')->check()) {
            return redirect()->route('painel.dashboard');
        }
        return view('painel.auth.registo');
    }

    public function registoPost(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:imobiliarias,email',
            'telefone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'nif' => 'nullable|string|max:20',
            'provincia' => 'nullable|string|max:50',
            'municipio' => 'nullable|string|max:50',
        ]);

        $validated['estado'] = 'pendente';

        $imobiliaria = Imobiliaria::create($validated);

        SendNovaImobiliariaEmail::dispatch($imobiliaria);

        return redirect()->route('painel.login')
            ->with('success', 'Conta criada com sucesso! Aguarde aprovação da equipa QNB.');
    }

    public function logout(Request $request)
    {
        Auth::guard('imobiliaria')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    // ==================== DASHBOARD ====================

    public function dashboard()
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        $plano = $imobiliaria->getPlanoAtivo();

        $imoveis = $imobiliaria->imoveis()->with('fotos')->get();

        $stats = [
            'total' => $imoveis->count(),
            'aprovados' => $imoveis->where('estado', 'aprovado')->count(),
            'pendentes' => $imoveis->where('estado', 'pendente')->count(),
            'rejeitados' => $imoveis->where('estado', 'rejeitado')->count(),
            'destaques' => $imoveis->where('destaque', true)->count(),
            'visualizacoes' => $imoveis->sum('visualizacoes'),
            'contactos' => $imoveis->sum('contactos'),
        ];

        $mensagens = $imobiliaria->mensagens()->orderByDesc('created_at')->limit(5)->get();
        $mensagensNaoLidas = $imobiliaria->mensagens()->where('lida', false)->count();

        return view('painel.dashboard', compact('imobiliaria', 'plano', 'imoveis', 'stats', 'mensagens', 'mensagensNaoLidas'));
    }

    // ==================== PERFIL ====================

    public function perfil()
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        $plano = $imobiliaria->getPlanoAtivo();
        return view('painel.perfil', compact('imobiliaria', 'plano'));
    }

    public function perfilUpdate(Request $request)
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:imobiliarias,email,' . $imobiliaria->id,
            'telefone' => 'required|string|max:20',
            'nif' => 'nullable|string|max:20',
            'provincia' => 'nullable|string|max:50',
            'municipio' => 'nullable|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($imobiliaria->foto && !str_starts_with($imobiliaria->foto, 'assets/')) {
                Storage::disk('public')->delete($imobiliaria->foto);
            }
            $validated['foto'] = $request->file('foto')->store('imobiliarias/perfil', 'public');
        }

        $imobiliaria->update($validated);

        return redirect()->route('painel.perfil')->with('success', 'Perfil atualizado com sucesso!');
    }

    // ==================== PLANO ====================

    public function ativarPlano()
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        $planos = Plano::where('ativo', true)->get();
        return view('painel.ativar-plano', compact('imobiliaria', 'planos'));
    }

    /**
     * Criar fatura imediatamente ao selecionar plano.
     * Redirect direto para a fatura (upload comprovativo).
     */
    public function criarFaturaPlano(Request $request)
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();

        $validated = $request->validate([
            'plano_id' => 'required|exists:planos,id',
        ]);

        $plano = Plano::findOrFail($validated['plano_id']);

        $service = app(PagamentoService::class);
        $fatura = $service->criarFaturaDireta($imobiliaria, $plano);

        return redirect()->route('painel.faturas.show', $fatura)
            ->with('success', 'Fatura criada! Envie o comprovativo de pagamento para ativação do plano.');
    }

    // ==================== IMÓVEIS ====================

    public function imoveis()
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        $plano = $imobiliaria->getPlanoAtivo();
        $imoveis = $imobiliaria->imoveis()->with('fotos')->orderByDesc('created_at')->get();

        return view('painel.imoveis.index', compact('imobiliaria', 'plano', 'imoveis'));
    }

    public function imovelForm($id = null)
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        $plano = $imobiliaria->getPlanoAtivo();
        $imovel = $id ? $imobiliaria->imoveis()->with('fotos', 'amenidades', 'canais')->findOrFail($id) : null;

        // Bloquear criação de novo imóvel se não tem plano ativo ou posts esgotados
        if (!$imovel && (!$plano || $plano->posts_usados >= $plano->plano->posts_limite)) {
            return redirect()->route('painel.ativar-plano')
                ->with('error', 'Precisa de um plano ativo com posts disponíveis para criar imóveis.');
        }

        $amenidades = \App\Models\Amenidade::orderBy('nome')->get();

        return view('painel.imoveis.form', compact('imobiliaria', 'plano', 'imovel', 'amenidades'));
    }

    public function imovelStore(Request $request)
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        $plano = $imobiliaria->getPlanoAtivo();

        if (!$plano) {
            return redirect()->route('painel.ativar-plano')
                ->with('error', 'Precisa de um plano ativo para criar imóveis.');
        }

        if ($plano->posts_usados >= $plano->plano->posts_limite) {
            return redirect()->route('painel.imoveis')
                ->with('error', 'Limite de posts atingido. Ative um plano superior.');
        }

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'moeda' => 'required|in:Kz,USD',
            'finalidade' => 'required|in:arrendar,vender',
            'tipo' => 'required|in:apartamento,vivenda,terreno,loja,escritorio,armazem,quintal',
            'area' => 'nullable|numeric|min:0',
            'quartos' => 'nullable|integer|min:0',
            'wc' => 'nullable|integer|min:0',
            'estacionamento' => 'nullable|integer|min:0',
            'ano_construcao' => 'nullable|integer|min:1900|max:' . date('Y'),
            'estado_imovel' => 'nullable|string|max:50',
            'provincia' => 'required|string|max:50',
            'municipio' => 'required|string|max:50',
            'bairro' => 'nullable|string|max:100',
            'endereco' => 'nullable|string|max:100',
            'fotos' => 'required|array|min:5|max:10',
            'fotos.*' => 'file|image|mimes:jpeg,png,webp|max:5120',
            'amenidades' => 'nullable|array',
            'amenidades.*' => 'exists:amenidades,id',
        ]);

        $validated['imobiliaria_id'] = $imobiliaria->id;
        $validated['estado'] = 'pendente';
        $validated['referencia'] = 'QNB-' . strtoupper(Str::random(8));

        $fotos = $validated['fotos'];
        unset($validated['fotos']);
        $amenidades = $validated['amenidades'] ?? [];
        unset($validated['amenidades']);

        $imovel = Imovel::create($validated);

        // Upload fotos
        foreach ($fotos as $i => $foto) {
            $caminho = $foto->store('imoveis/' . $imovel->id, 'public');
            $imovel->fotos()->create([
                'caminho' => $caminho,
                'legenda' => 'Foto ' . ($i + 1),
                'capa' => $i === 0,
                'ordem' => $i,
            ]);
        }

        // Amenidades
        $imovel->amenidades()->sync($amenidades);

        // Incrementar posts usados
        $plano->increment('posts_usados');

        return redirect()->route('painel.imoveis')
            ->with('success', 'Imóvel cadastrado com sucesso! Aguarda aprovação da equipa QNB.');
    }

    public function imovelUpdate(Request $request, $id)
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        $imovel = $imobiliaria->imoveis()->findOrFail($id);

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'moeda' => 'required|in:Kz,USD',
            'finalidade' => 'required|in:arrendar,vender',
            'tipo' => 'required|in:apartamento,vivenda,terreno,loja,escritorio,armazem,quintal',
            'area' => 'nullable|numeric|min:0',
            'quartos' => 'nullable|integer|min:0',
            'wc' => 'nullable|integer|min:0',
            'estacionamento' => 'nullable|integer|min:0',
            'ano_construcao' => 'nullable|integer|min:1900|max:' . date('Y'),
            'estado_imovel' => 'nullable|string|max:50',
            'provincia' => 'required|string|max:50',
            'municipio' => 'required|string|max:50',
            'bairro' => 'nullable|string|max:100',
            'endereco' => 'nullable|string|max:100',
            'fotos' => 'nullable|array|min:5|max:10',
            'fotos.*' => 'file|image|mimes:jpeg,png,webp|max:5120',
            'amenidades' => 'nullable|array',
            'amenidades.*' => 'exists:amenidades,id',
        ]);

        $amenidades = $validated['amenidades'] ?? [];
        unset($validated['amenidades']);

        // Novas fotos
        if (!empty($validated['fotos'])) {
            // Apagar fotos antigas se existirem novas
            foreach ($imovel->fotos as $foto) {
                Storage::disk('public')->delete($foto->caminho);
                $foto->delete();
            }

            $fotos = $validated['fotos'];
            unset($validated['fotos']);

            foreach ($fotos as $i => $foto) {
                $caminho = $foto->store('imoveis/' . $imovel->id, 'public');
                $imovel->fotos()->create([
                    'caminho' => $caminho,
                    'legenda' => 'Foto ' . ($i + 1),
                    'capa' => $i === 0,
                    'ordem' => $i,
                ]);
            }
        } else {
            unset($validated['fotos']);
        }

        $imovel->update($validated);
        $imovel->amenidades()->sync($amenidades);

        return redirect()->route('painel.imoveis')
            ->with('success', 'Imóvel atualizado com sucesso!');
    }

    public function imovelDelete($id)
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        $imovel = $imobiliaria->imoveis()->findOrFail($id);

        // Apagar fotos
        foreach ($imovel->fotos as $foto) {
            Storage::disk('public')->delete($foto->caminho);
        }

        $imovel->amenidades()->detach();
        $imovel->canais()->delete();
        $imovel->fotos()->delete();
        $imovel->delete();

        // Decrementar posts usados
        $plano = $imobiliaria->getPlanoAtivo();
        if ($plano && $plano->posts_usados > 0) {
            $plano->decrement('posts_usados');
        }

        return redirect()->route('painel.imoveis')
            ->with('success', 'Imóvel removido com sucesso!');
    }

    public function imovelDestaque($id)
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        $imovel = $imobiliaria->imoveis()->findOrFail($id);

        if ($imovel->estado !== 'aprovado') {
            return redirect()->route('painel.imoveis')
                ->with('error', 'Apenas imóveis aprovados podem ser destacados.');
        }

        $imovel->update(['destaque' => !$imovel->destaque]);

        return redirect()->route('painel.imoveis')
            ->with('success', $imovel->destaque ? 'Imóvel adicionado aos destaques!' : 'Imóvel removido dos destaques.');
    }

    // ==================== MENSAGENS ====================

    public function mensagens()
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        $mensagens = $imobiliaria->mensagens()->with('imovel')->orderByDesc('created_at')->get();

        return view('painel.mensagens', compact('imobiliaria', 'mensagens'));
    }

    public function mensagemLida($id)
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        $mensagem = $imobiliaria->mensagens()->findOrFail($id);
        $mensagem->update(['lida' => true]);

        return redirect()->route('painel.mensagens');
    }

    // ==================== MENSAGENS DO ADMIN ====================

    public function adminMensagens()
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        $threads = AdminMensagem::where('imobiliaria_id', $imobiliaria->id)
            ->whereNull('thread_id')
            ->with(['admin', 'respostas.admin'])
            ->orderByDesc('created_at')
            ->get();

        return view('painel.admin-mensagens', compact('imobiliaria', 'threads'));
    }

    public function adminMensagemShow($id)
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        $thread = AdminMensagem::where('imobiliaria_id', $imobiliaria->id)
            ->where('id', $id)
            ->with(['admin', 'respostas.admin'])
            ->firstOrFail();

        // Marcar como lida
        if (!$thread->lida) {
            $thread->update(['lida' => true, 'lida_em' => now()]);
        }

        return view('painel.admin-mensagem-show', compact('imobiliaria', 'thread'));
    }

    public function adminMensagemResponder(Request $request, $id)
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        $thread = AdminMensagem::where('imobiliaria_id', $imobiliaria->id)
            ->where('id', $id)
            ->firstOrFail();

        $request->validate([
            'texto' => 'required|string|min:5',
        ]);

        AdminMensagem::create([
            'thread_id' => $thread->id,
            'imobiliaria_id' => $imobiliaria->id,
            'autor_tipo' => 'imobiliaria',
            'texto' => $request->texto,
            'lida' => false,
        ]);

        return redirect()->route('painel.admin-mensagens.show', $thread->id)
            ->with('sucesso', 'Resposta enviada com sucesso.');
    }

    public function adminMensagemLida($id)
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        $thread = AdminMensagem::where('imobiliaria_id', $imobiliaria->id)
            ->where('id', $id)
            ->firstOrFail();

        $thread->update(['lida' => true, 'lida_em' => now()]);

        return redirect()->route('painel.admin-mensagens');
    }

    // ==================== DESTAQUES ====================

    public function destaques()
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        $plano = $imobiliaria->getPlanoAtivo();
        $imoveis = $imobiliaria->imoveis()->with('fotos')->where('destaque', true)->orderByDesc('created_at')->get();

        return view('painel.destaques', compact('imobiliaria', 'plano', 'imoveis'));
    }

    // ==================== VISITAS ====================

    public function visitas(Request $request)
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        $query = $imobiliaria->visitas()->with('imovel');

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $visitas = $query->orderBy('data_visita', 'desc')->paginate(15);
        $estatisticas = [
            'hoje' => $imobiliaria->visitas()->whereDate('data_visita', today())->count(),
            'pendente' => $imobiliaria->visitas()->where('estado', 'pendente')->count(),
            'confirmada' => $imobiliaria->visitas()->where('estado', 'confirmada')->count(),
            'concluida' => $imobiliaria->visitas()->where('estado', 'concluida')->count(),
        ];

        return view('painel.visitas', compact('imobiliaria', 'visitas', 'estatisticas'));
    }

    public function visitaEstado($id, Request $request)
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        $visita = $imobiliaria->visitas()->findOrFail($id);

        $validated = $request->validate([
            'estado' => 'required|in:confirmada,cancelada,concluida',
            'motivo' => 'nullable|string|max:500',
        ]);

        $service = new \App\Services\Cliente\VisitaService();

        match ($validated['estado']) {
            'confirmada' => $service->aceitar($visita),
            'cancelada' => $service->recusar($visita, $validated['motivo'] ?? null),
            'concluida' => $service->concluir($visita),
        };

        if ($validated['estado'] === 'confirmada') {
            \App\Jobs\SendVisitaConfirmadaEmail::dispatch($visita);
            if ($visita->cliente_id) {
                \App\Services\PushNotificationService::enviar(
                    $visita->cliente_id,
                    'Visita confirmada',
                    'A sua visita ao imóvel "' . $visita->imovel->titulo . '" foi confirmada para ' . $visita->data_visita->format('d/m/Y H:i') . '.',
                    route('cliente.visitas')
                );
            }
        } elseif ($validated['estado'] === 'cancelada') {
            \App\Jobs\SendVisitaRecusadaEmail::dispatch($visita);
            if ($visita->cliente_id) {
                \App\Services\PushNotificationService::enviar(
                    $visita->cliente_id,
                    'Visita cancelada',
                    'A sua visita ao imóvel "' . $visita->imovel->titulo . '" foi cancelada.',
                    route('cliente.visitas')
                );
            }
        }

        return redirect()->route('painel.visitas')->with('success', 'Estado da visita atualizado.');
    }

    public function mensagemNotificar($id, Request $request)
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        $mensagem = $imobiliaria->mensagens()->findOrFail($id);

        $validated = $request->validate([
            'disponivel' => 'required|boolean',
        ]);

        if (!$mensagem->imovel_id) {
            return back()->with('error', 'Mensagem sem imóvel associado.');
        }

        $imovel = \App\Models\Imovel::findOrFail($mensagem->imovel_id);

        \App\Jobs\SendDisponibilidadeNotificadaEmail::dispatch($mensagem, $imovel, $validated['disponivel']);

        // Notificar cliente in-app (C7)
        if ($mensagem->cliente_id) {
            $titulo = $validated['disponivel'] ? 'Imóvel disponível' : 'Imóvel indisponível';
            $texto = $validated['disponivel']
                ? 'Boa notícia! O imóvel "' . $imovel->titulo . '" que perguntou ainda está disponível.'
                : 'Infelizmente o imóvel "' . $imovel->titulo . '" que perguntou já não está disponível.';

            \App\Services\Cliente\ClienteNotificacaoService::enviar(
                $mensagem->cliente_id,
                'mensagem',
                $titulo,
                $texto,
                route('cliente.mensagens.show', $mensagem)
            );

            \App\Services\PushNotificationService::enviar(
                $mensagem->cliente_id,
                $titulo,
                $texto,
                route('cliente.mensagens.show', $mensagem)
            );
        }

        $mensagem->update(['lida' => true]);

        return redirect()->route('painel.mensagens')->with('success', 'Notificação enviada com sucesso.');
    }

    // ==================== ESTATÍSTICAS ====================

    public function estatisticas()
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        $imoveis = $imobiliaria->imoveis()->get();

        $stats = [
            'total_visualizacoes' => $imoveis->sum('visualizacoes'),
            'total_contactos' => $imoveis->sum('contactos'),
            'total_imoveis' => $imoveis->count(),
            'aprovados' => $imoveis->where('estado', 'aprovado')->count(),
            'pendentes' => $imoveis->where('estado', 'pendente')->count(),
        ];

        $maisVistos = $imoveis->sortByDesc('visualizacoes')->take(5);
        $maisContactados = $imoveis->sortByDesc('contactos')->take(5);

        return view('painel.estatisticas', compact('imobiliaria', 'stats', 'maisVistos', 'maisContactados'));
    }

    // ==================== CANAIS DE CONTACTO ====================

    public function canais()
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        $canais = $imobiliaria->canais()->get();

        return view('painel.canais', compact('imobiliaria', 'canais'));
    }

    public function canaisSalvar(Request $request)
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();

        $validated = $request->validate([
            'canais' => 'nullable|array',
            'canais.*.tipo' => 'required_with:canais|in:telefone,whatsapp,email,facebook,instagram,linkedin,outro',
            'canais.*.valor' => 'required_with:canais|string|max:255',
        ]);

        // Apagar canais existentes
        $imobiliaria->canais()->delete();

        // Criar novos canais
        if (!empty($validated['canais'])) {
            foreach ($validated['canais'] as $canal) {
                if (!empty($canal['tipo']) && !empty($canal['valor'])) {
                    $imobiliaria->canais()->create($canal);
                }
            }
        }

        return redirect()->route('painel.perfil.canais')->with('success', 'Canais de contacto atualizados.');
    }

    // ==================== ALTERAR PASSWORD ====================

    public function passwordForm()
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        return view('painel.password', compact('imobiliaria'));
    }

    public function passwordSalvar(Request $request)
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();

        $validated = $request->validate([
            'password_atual' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($validated['password_atual'], $imobiliaria->password)) {
            return back()->withErrors(['password_atual' => 'A palavra-passe atual está incorreta.']);
        }

        $imobiliaria->update(['password' => $validated['password']]);

        return redirect()->route('painel.perfil')->with('success', 'Palavra-passe alterada com sucesso!');
    }

    // ==================== PAGAMENTO ====================

    public function pagamentoNovo()
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        $planoAtual = $imobiliaria->getPlanoAtivo();
        $planos = Plano::where('ativo', true)->orderBy('ordem')->get();

        return view('painel.pagamento.novo', compact('imobiliaria', 'planoAtual', 'planos'));
    }

    public function pagamentoSalvar(Request $request)
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();

        $validated = $request->validate([
            'plano_id' => 'required|exists:planos,id',
            'metodo' => 'required|in:transferencia,multicaixa,dinheiro,outro',
            'referencia' => 'nullable|string|max:100',
            'comprovativo' => 'nullable|file|image|mimes:jpeg,png,webp|max:5120',
        ]);

        $plano = Plano::findOrFail($validated['plano_id']);

        $service = app(PagamentoService::class);
        $subscricao = $service->criarPagamento(
            $imobiliaria,
            $plano,
            $validated['metodo'],
            $validated['referencia'] ?? null,
            $request->file('comprovativo'),
        );

        return redirect()->route('painel.faturas')
            ->with('success', 'Fatura criada com sucesso! Envie o comprovativo de pagamento para ativação do plano.');
    }

    public function pagamentoConfirmado()
    {
        return view('painel.pagamento.confirmado');
    }

    public function pagamentos()
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        $pagamentos = \App\Models\Pagamento::where('imobiliaria_id', $imobiliaria->id)
            ->with('subscricao.plano')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('painel.pagamentos.index', compact('pagamentos'));
    }

    public function pagamentoShow($id)
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        $pagamento = \App\Models\Pagamento::where('imobiliaria_id', $imobiliaria->id)
            ->with('subscricao.plano')
            ->findOrFail($id);

        return view('painel.pagamentos.show', compact('pagamento'));
    }

    public function faturaDownload($id)
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();
        $fatura = \App\Models\Fatura::where('imobiliaria_id', $imobiliaria->id)
            ->findOrFail($id);

        $service = new \App\Services\InvoiceService();
        return $service->download($fatura);
    }
}
