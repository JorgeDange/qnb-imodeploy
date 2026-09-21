<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SitePublicoController;
use App\Http\Controllers\PainelController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Imóveis
Route::get('/imoveis', [SitePublicoController::class, 'imoveis'])->name('imoveis.index');
Route::get('/imoveis/{referencia}', [SitePublicoController::class, 'show'])->name('imoveis.show');

// Páginas institucionais
Route::get('/contacto', [SitePublicoController::class, 'contacto'])->name('contacto');
Route::post('/contacto', [SitePublicoController::class, 'contactoEnviar'])->name('contacto.enviar');
Route::get('/sobre', [SitePublicoController::class, 'sobre'])->name('sobre');
Route::get('/como-anunciar', [SitePublicoController::class, 'comoFunciona'])->name('como-funciona');

// Painel do cliente
Route::prefix('painel')->name('painel.')->group(function () {
    Route::get('/login', [PainelController::class, 'login'])->name('login');
    Route::post('/login', [PainelController::class, 'loginPost'])->name('login.post')->middleware('throttle:5,1');
    Route::get('/registo', [PainelController::class, 'registo'])->name('registo');
    Route::post('/registo', [PainelController::class, 'registoPost'])->name('registo.post');

    Route::middleware(['auth:imobiliaria', 'conta.aprovada'])->group(function () {
        Route::post('/logout', [PainelController::class, 'logout'])->name('logout');
        Route::get('/', [PainelController::class, 'dashboard'])->name('dashboard');
        Route::get('/perfil', [PainelController::class, 'perfil'])->name('perfil');
        Route::put('/perfil', [PainelController::class, 'perfilUpdate'])->name('perfil.update');
        Route::get('/ativar-plano', [PainelController::class, 'ativarPlano'])->name('ativar-plano');
        Route::post('/ativar-plano', [PainelController::class, 'criarFaturaPlano'])->name('ativar-plano.criar');
        Route::get('/imoveis', [PainelController::class, 'imoveis'])->name('imoveis');
        Route::get('/imoveis/novo', [PainelController::class, 'imovelForm'])->name('imoveis.novo');
        Route::get('/imoveis/{id}/editar', [PainelController::class, 'imovelForm'])->name('imoveis.editar');
        Route::post('/imoveis', [PainelController::class, 'imovelStore'])->name('imoveis.store');
        Route::put('/imoveis/{id}', [PainelController::class, 'imovelUpdate'])->name('imoveis.update');
        Route::delete('/imoveis/{id}', [PainelController::class, 'imovelDelete'])->name('imoveis.deletar');
        Route::post('/imoveis/{id}/destaque', [PainelController::class, 'imovelDestaque'])->name('imoveis.destaque');
        Route::get('/mensagens', [PainelController::class, 'mensagens'])->name('mensagens');
        Route::post('/mensagens/{id}/lida', [PainelController::class, 'mensagemLida'])->name('mensagens.lida');
        Route::post('/mensagens/{id}/notificar', [PainelController::class, 'mensagemNotificar'])->name('mensagens.notificar');

        // Mensagens do Admin
        Route::get('/admin-mensagens', [PainelController::class, 'adminMensagens'])->name('admin-mensagens');
        Route::get('/admin-mensagens/{id}', [PainelController::class, 'adminMensagemShow'])->name('admin-mensagens.show');
        Route::post('/admin-mensagens/{id}/responder', [PainelController::class, 'adminMensagemResponder'])->name('admin-mensagens.responder');
        Route::post('/admin-mensagens/{id}/lida', [PainelController::class, 'adminMensagemLida'])->name('admin-mensagens.lida');

        // Destaques
        Route::get('/destaques', [PainelController::class, 'destaques'])->name('destaques');

        // Visitas
        Route::get('/visitas', [PainelController::class, 'visitas'])->name('visitas');
        Route::post('/visitas/{id}/estado', [PainelController::class, 'visitaEstado'])->name('visitas.estado');

        // Estatísticas
        Route::get('/estatisticas', [PainelController::class, 'estatisticas'])->name('estatisticas');

        // Perfil �?" canais de contacto
        Route::get('/perfil/canais', [PainelController::class, 'canais'])->name('perfil.canais');
        Route::post('/perfil/canais', [PainelController::class, 'canaisSalvar'])->name('perfil.canais.salvar');

        // Perfil �?" alterar password
        Route::get('/perfil/password', [PainelController::class, 'passwordForm'])->name('perfil.password');
        Route::post('/perfil/password', [PainelController::class, 'passwordSalvar'])->name('perfil.password.salvar');

        // Faturas
        Route::get('/faturas', [\App\Http\Controllers\Painel\FaturaController::class, 'index'])->name('faturas');
        Route::get('/faturas/{fatura}', [\App\Http\Controllers\Painel\FaturaController::class, 'show'])->name('faturas.show');
        Route::get('/faturas/{fatura}/download', [\App\Http\Controllers\Painel\FaturaController::class, 'download'])->name('faturas.download');
        Route::get('/faturas/{fatura}/recibo', [\App\Http\Controllers\Painel\FaturaController::class, 'downloadRecibo'])->name('faturas.recibo');
        Route::post('/faturas/{fatura}/comprovativo', [\App\Http\Controllers\Painel\FaturaController::class, 'submeterComprovativo'])->name('faturas.comprovativo');
    });
});

// CLIENTE
Route::prefix('cliente')->name('cliente.')->group(function () {

    // Auth (guest)
    Route::middleware('guest:cliente')->group(function () {
        Route::get('login', [\App\Http\Controllers\Cliente\ClienteAuthController::class, 'showLogin'])->name('login');
        Route::post('login', [\App\Http\Controllers\Cliente\ClienteAuthController::class, 'login']);
        Route::get('registo', [\App\Http\Controllers\Cliente\ClienteAuthController::class, 'showRegisto'])->name('registo');
        Route::post('registo', [\App\Http\Controllers\Cliente\ClienteAuthController::class, 'registo']);
    });

    // Área autenticada
    Route::middleware(['auth:cliente', 'cliente.ativo'])->group(function () {
        Route::get('dashboard', [\App\Http\Controllers\Cliente\ClienteDashboardController::class, 'index'])->name('dashboard');

        Route::get('perfil', [\App\Http\Controllers\Cliente\ClientePerfilController::class, 'edit'])->name('perfil');
        Route::put('perfil', [\App\Http\Controllers\Cliente\ClientePerfilController::class, 'update'])->name('perfil.update');
        Route::put('password', [\App\Http\Controllers\Cliente\ClientePerfilController::class, 'updatePassword'])->name('perfil.password');
        Route::post('perfil/foto', [\App\Http\Controllers\Cliente\ClientePerfilController::class, 'uploadFoto'])->name('perfil.foto');

        Route::get('favoritos', [\App\Http\Controllers\Cliente\ClienteFavoritoController::class, 'index'])->name('favoritos');
        Route::post('favoritos/{imovel}', [\App\Http\Controllers\Cliente\ClienteFavoritoController::class, 'store'])->name('favoritos.store');
        Route::delete('favoritos/{imovel}', [\App\Http\Controllers\Cliente\ClienteFavoritoController::class, 'destroy'])->name('favoritos.destroy');

        Route::get('mensagens', [\App\Http\Controllers\Cliente\ClienteMensagemController::class, 'index'])->name('mensagens');
        Route::get('mensagens/{thread}', [\App\Http\Controllers\Cliente\ClienteMensagemController::class, 'show'])->name('mensagens.show');
        Route::post('mensagens/{thread}/responder', [\App\Http\Controllers\Cliente\ClienteMensagemController::class, 'responder'])->name('mensagens.responder');
        Route::post('imoveis/{imovel}/mensagem', [\App\Http\Controllers\Cliente\ClienteMensagemController::class, 'enviar'])->name('mensagens.enviar');

        Route::get('visitas', [\App\Http\Controllers\Cliente\ClienteVisitaController::class, 'index'])->name('visitas');
        Route::post('visitas/{imovel}', [\App\Http\Controllers\Cliente\ClienteVisitaController::class, 'store'])->name('visitas.store');
        Route::post('visitas/{visita}/cancelar', [\App\Http\Controllers\Cliente\ClienteVisitaController::class, 'cancelar'])->name('visitas.cancelar');
        Route::get('imoveis/{imovel}/dias-disponiveis', [\App\Http\Controllers\Cliente\ClienteVisitaController::class, 'diasDisponiveis'])->name('imoveis.dias-disponiveis');

        Route::get('pesquisas', [\App\Http\Controllers\Cliente\ClientePesquisaController::class, 'index'])->name('pesquisas');
        Route::post('pesquisas', [\App\Http\Controllers\Cliente\ClientePesquisaController::class, 'store'])->name('pesquisas.store');
        Route::delete('pesquisas/{pesquisa}', [\App\Http\Controllers\Cliente\ClientePesquisaController::class, 'destroy'])->name('pesquisas.destroy');

        // Notificações
        Route::get('notificacoes', [\App\Http\Controllers\Cliente\ClienteNotificacaoController::class, 'index'])->name('notificacoes');
        Route::post('notificacoes/{id}/ler', [\App\Http\Controllers\Cliente\ClienteNotificacaoController::class, 'ler'])->name('notificacoes.ler');
        Route::post('notificacoes/ler-todas', [\App\Http\Controllers\Cliente\ClienteNotificacaoController::class, 'lerTodas'])->name('notificacoes.ler-todas');

        // Denúncias
        Route::get('denuncias', [\App\Http\Controllers\Cliente\ClienteDenunciaController::class, 'index'])->name('denuncias');
        Route::post('denuncias', [\App\Http\Controllers\Cliente\ClienteDenunciaController::class, 'store'])->name('denuncias.store')->middleware('throttle:10,1');

        // Avaliações
        Route::get('avaliacoes', [\App\Http\Controllers\Cliente\ClienteAvaliacaoController::class, 'index'])->name('avaliacoes');
        Route::post('avaliacoes', [\App\Http\Controllers\Cliente\ClienteAvaliacaoController::class, 'store'])->name('avaliacoes.store')->middleware('throttle:10,1');
        Route::post('avaliacoes/{avaliacao}/reenviar', [\App\Http\Controllers\Cliente\ClienteAvaliacaoController::class, 'reenviar'])->name('avaliacoes.reenviar');

        // Push Tokens (notificações)
        Route::post('push-tokens', [\App\Http\Controllers\Cliente\ClientePushTokenController::class, 'store'])->name('push-tokens.store');
        Route::delete('push-tokens', [\App\Http\Controllers\Cliente\ClientePushTokenController::class, 'destroy'])->name('push-tokens.destroy');

        Route::post('logout', [\App\Http\Controllers\Cliente\ClienteAuthController::class, 'logout'])->name('logout');
    });
});
// Health Check (público)
Route::get('/health', function () {
    $checks = [
        'database' => fn () => \Illuminate\Support\Facades\DB::connection()->getPdo() ? 'ok' : 'erro',
        'cache' => fn () => \Illuminate\Support\Facades\Cache::store('file')->put('health', 1) ? 'ok' : 'erro',
        'queue' => fn () => class_exists(\Illuminate\Queue\QueueManager::class) ? 'ok' : 'erro',
        'storage' => fn () => is_writable(storage_path()) ? 'ok' : 'erro',
    ];

    $result = [];
    $allOk = true;
    foreach ($checks as $name => $check) {
        try {
            $result[$name] = $check();
        } catch (\Throwable $e) {
            $result[$name] = 'erro: ' . $e->getMessage();
            $allOk = false;
        }
    }

    return response()->json([
        'status' => $allOk ? 'healthy' : 'degraded',
        'checks' => $result,
        'timestamp' => now()->toIso8601String(),
    ], $allOk ? 200 : 503);
});
