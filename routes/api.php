<?php

use App\Http\Controllers\Api\AmenidadeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Cliente\ClienteAuthController;
use App\Http\Controllers\Api\ImovelPublicoController;
use App\Http\Controllers\Api\Painel\DashboardController;
use App\Http\Controllers\Api\Painel\ImovelController;
use App\Http\Controllers\Api\Painel\MensagemController;
use App\Http\Controllers\Api\Painel\PerfilController;
use App\Http\Controllers\Api\Painel\PlanoController;
use App\Http\Controllers\Api\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('login', fn () => response()->json(['mensagem' => 'Não autenticado.'], 401))->name('login');

Route::prefix('v1')->group(function () {

    /* ---- Área pública ---- */
    Route::post('registo', [AuthController::class, 'registo']);
    Route::post('login', [AuthController::class, 'login']);

    Route::get('imoveis', [ImovelPublicoController::class, 'index']);
    Route::get('imoveis/{imovel}', [ImovelPublicoController::class, 'show']);
    Route::get('destaques', [SiteController::class, 'destaques']);
    Route::get('estatisticas', [SiteController::class, 'estatisticas']);
    Route::get('cidades', [SiteController::class, 'cidades']);
    Route::get('amenidades', [AmenidadeController::class, 'index']);
    Route::get('depoimentos', [SiteController::class, 'depoimentos']);
    Route::get('parceiros', [SiteController::class, 'parceiros']);
    Route::get('settings', [SiteController::class, 'settings']);
    Route::post('mensagens', [SiteController::class, 'enviarMensagem']);

    /* ---- Área autenticada (painel do cliente) ---- */
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);

        Route::get('perfil', [PerfilController::class, 'show']);
        Route::put('perfil', [PerfilController::class, 'update']);

        Route::get('plano', [PlanoController::class, 'resumo']);
        Route::post('plano/pedido', [PlanoController::class, 'pedido']);

        Route::middleware('conta.aprovada')->group(function () {
            Route::get('conta/imoveis', [ImovelController::class, 'index']);
            Route::get('conta/imoveis/{imovel}', [ImovelController::class, 'show']);
            Route::delete('conta/imoveis/{imovel}', [ImovelController::class, 'destroy']);
            Route::post('conta/imoveis/{imovel}/destaque', [ImovelController::class, 'destaque']);

            Route::get('conta/mensagens', [MensagemController::class, 'index']);
            Route::post('conta/mensagens/{mensagem}/lida', [MensagemController::class, 'marcarLida']);

            Route::get('conta/dashboard', [DashboardController::class, 'index']);
        });

        Route::middleware('plano.ativo')->group(function () {
            Route::post('conta/imoveis', [ImovelController::class, 'store']);
            Route::put('conta/imoveis/{imovel}', [ImovelController::class, 'update']);
        });
    });

    /* ---- Área do Cliente (consumidor final) ---- */
    Route::prefix('cliente')->group(function () {

        // Públicas
        Route::post('registo',            [ClienteAuthController::class, 'registo']);
        Route::post('login',              [ClienteAuthController::class, 'login'])
            ->middleware('throttle:5,1');
        Route::post('verificar-email',    [ClienteAuthController::class, 'verificarEmail']);
        Route::post('recuperar-password', [ClienteAuthController::class, 'recuperarPassword'])
            ->middleware('throttle:3,1');
        Route::post('redefinir-password', [ClienteAuthController::class, 'redefinirPassword']);

        // Protegidas
        Route::middleware(['auth:cliente-api', 'cliente.ativo'])->group(function () {
            Route::get('me',                    [ClienteAuthController::class, 'me']);
            Route::post('logout',               [ClienteAuthController::class, 'logout']);
            Route::post('reenviar-verificacao', [ClienteAuthController::class, 'reenviarVerificacao']);

            // Perfil
            Route::get('perfil',   [ClienteAuthController::class, 'perfil']);
            Route::put('perfil',   [ClienteAuthController::class, 'atualizarPerfil']);

            // Favoritos
            Route::get('favoritos',          [ClienteAuthController::class, 'favoritos']);
            Route::post('favoritos',         [ClienteAuthController::class, 'adicionaFavorito']);
            Route::delete('favoritos/{id}',  [ClienteAuthController::class, 'removeFavorito']);

            // Mensagens
            Route::get('mensagens', [ClienteAuthController::class, 'mensagens']);

            // Visitas
            Route::get('visitas', [ClienteAuthController::class, 'visitas']);
            Route::post('visitas', [ClienteAuthController::class, 'agendarVisita']);
        });
    });
});