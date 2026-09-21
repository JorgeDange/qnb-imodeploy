<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Cliente;
use App\Models\PushToken;
use App\Services\PushNotificationService;

class PushNotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function cliente_pode_registar_push_token()
    {
        $cliente = Cliente::factory()->create();

        $this->actingAs($cliente, 'cliente')
            ->postJson('/cliente/push-tokens', [
                'token' => 'push-token-abc-123',
                'plataforma' => 'web',
            ])
            ->assertOk()
            ->assertJson(['sucesso' => true]);

        $this->assertDatabaseHas('push_tokens', [
            'cliente_id' => $cliente->id,
            'token' => 'push-token-abc-123',
            'plataforma' => 'web',
            'ativo' => true,
        ]);
    }

    /** @test */
    public function cliente_pode_remover_push_token()
    {
        $cliente = Cliente::factory()->create();

        $this->actingAs($cliente, 'cliente')
            ->postJson('/cliente/push-tokens', [
                'token' => 'push-token-to-remove',
            ]);

        $this->actingAs($cliente, 'cliente')
            ->deleteJson('/cliente/push-tokens', [
                'token' => 'push-token-to-remove',
            ])
            ->assertOk();

        $token = PushToken::where('token', 'push-token-to-remove')->first();
        $this->assertFalse($token->ativo);
    }

    /** @test */
    public function token_duplicado_e_atualizado()
    {
        $cliente = Cliente::factory()->create();

        $this->actingAs($cliente, 'cliente')
            ->postJson('/cliente/push-tokens', [
                'token' => 'duplicate-token',
            ]);

        $this->actingAs($cliente, 'cliente')
            ->postJson('/cliente/push-tokens', [
                'token' => 'duplicate-token',
            ]);

        $this->assertEquals(1, PushToken::where('token', 'duplicate-token')->count());
    }

    /** @test */
    public function push_notification_service_registra_token()
    {
        $cliente = Cliente::factory()->create();

        $token = PushNotificationService::registrarToken(
            $cliente->id,
            'service-token-123',
            'web',
            'Mozilla/5.0'
        );

        $this->assertEquals($cliente->id, $token->cliente_id);
        $this->assertEquals('service-token-123', $token->token);
        $this->assertTrue($token->ativo);
    }

    /** @test */
    public function push_notification_service_envia_para_tokens_ativos()
    {
        $cliente = Cliente::factory()->create();

        PushNotificationService::registrarToken($cliente->id, 'token-1');
        PushNotificationService::registrarToken($cliente->id, 'token-2');

        $enviados = PushNotificationService::enviar(
            $cliente->id,
            'Teste',
            'Mensagem de teste',
        );

        $this->assertEquals(2, $enviados);
    }

    /** @test */
    public function push_notification_service_remove_token()
    {
        $cliente = Cliente::factory()->create();

        PushNotificationService::registrarToken($cliente->id, 'to-disable');

        $result = PushNotificationService::removerToken('to-disable');

        $this->assertTrue($result);
        $token = PushToken::where('token', 'to-disable')->first();
        $this->assertFalse($token->ativo);
    }

    /** @test */
    public function push_tokens_nao_autenticado_sao_rejeitados()
    {
        $this->postJson('/cliente/push-tokens', [
            'token' => 'unauth-token',
        ])->assertRedirect();
    }
}
