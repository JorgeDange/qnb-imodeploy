<?php

namespace Tests\Feature\Cliente;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Cliente;
use App\Models\ClienteNotificacao;

class ClienteNotificacaoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function cliente_pode_ver_as_suas_notificacoes()
    {
        $cliente = Cliente::factory()->create();

        ClienteNotificacao::create([
            'cliente_id' => $cliente->id,
            'tipo' => 'visita',
            'titulo' => 'Visita confirmada',
            'mensagem' => 'A sua visita foi confirmada.',
        ]);

        $this->actingAs($cliente, 'cliente')
            ->get('/cliente/notificacoes')
            ->assertOk()
            ->assertSee('Visita confirmada');
    }

    /** @test */
    public function nao_lidas_aparecem_antes_das_lidas()
    {
        $cliente = Cliente::factory()->create();

        $lida = ClienteNotificacao::create([
            'cliente_id' => $cliente->id,
            'tipo' => 'visita',
            'titulo' => 'Notificação antiga',
            'mensagem' => 'Já lida.',
            'lida' => true,
            'lida_em' => now()->subDay(),
        ]);

        $naoLida = ClienteNotificacao::create([
            'cliente_id' => $cliente->id,
            'tipo' => 'mensagem',
            'titulo' => 'Notificação nova',
            'mensagem' => 'Por ler.',
        ]);

        $this->actingAs($cliente, 'cliente')
            ->get('/cliente/notificacoes')
            ->assertOk()
            ->assertSeeInOrder(['Notificação nova', 'Notificação antiga']);
    }

    /** @test */
    public function cliente_pode_marcar_notificacao_como_lida()
    {
        $cliente = Cliente::factory()->create();

        $notificacao = ClienteNotificacao::create([
            'cliente_id' => $cliente->id,
            'tipo' => 'visita',
            'titulo' => 'Teste',
            'mensagem' => 'Teste.',
        ]);

        $this->actingAs($cliente, 'cliente')
            ->post("/cliente/notificacoes/{$notificacao->id}/ler")
            ->assertRedirect()
            ->assertSessionHas('sucesso');

        $this->assertDatabaseHas('cliente_notificacoes', [
            'id' => $notificacao->id,
            'lida' => true,
        ]);
    }

    /** @test */
    public function cliente_nao_pode_marcar_notificacao_de_outro()
    {
        $cliente = Cliente::factory()->create();
        $outro = Cliente::factory()->create();

        $notificacao = ClienteNotificacao::create([
            'cliente_id' => $outro->id,
            'tipo' => 'visita',
            'titulo' => 'Teste',
            'mensagem' => 'Teste.',
        ]);

        $this->actingAs($cliente, 'cliente')
            ->post("/cliente/notificacoes/{$notificacao->id}/ler")
            ->assertNotFound();
    }

    /** @test */
    public function cliente_pode_marcar_todas_como_lidas()
    {
        $cliente = Cliente::factory()->create();

        ClienteNotificacao::create([
            'cliente_id' => $cliente->id, 'tipo' => 'visita', 'titulo' => 'A', 'mensagem' => 'A',
        ]);
        ClienteNotificacao::create([
            'cliente_id' => $cliente->id, 'tipo' => 'mensagem', 'titulo' => 'B', 'mensagem' => 'B',
        ]);

        $this->actingAs($cliente, 'cliente')
            ->post('/cliente/notificacoes/ler-todas')
            ->assertRedirect()
            ->assertSessionHas('sucesso');

        $this->assertEquals(0, $cliente->notificacoes()->naoLidas()->count());
    }

    /** @test */
    public function visit_service_notifica_quando_visita_confirmada()
    {
        $cliente = Cliente::factory()->create();
        $imovel = \App\Models\Imovel::factory()->create();
        $visita = \App\Models\Visita::create([
            'cliente_id' => $cliente->id,
            'imovel_id' => $imovel->id,
            'cliente_nome' => $cliente->nome,
            'cliente_email' => $cliente->email,
            'cliente_telefone' => $cliente->telefone ?? '+244921852727',
            'data_visita' => now()->addWeek(),
            'estado' => 'pendente',
        ]);

        $service = new \App\Services\Cliente\VisitaService();
        $service->aceitar($visita);

        $this->assertDatabaseHas('cliente_notificacoes', [
            'cliente_id' => $cliente->id,
            'tipo' => 'visita',
            'titulo' => 'Visita confirmada',
        ]);
    }
}
