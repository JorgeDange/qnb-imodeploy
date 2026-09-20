<?php

namespace Tests\Feature\Cliente;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Avaliacao;
use App\Models\Cliente;
use App\Models\Imovel;

class ClienteAvaliacaoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function cliente_pode_criar_avaliacao()
    {
        $cliente = Cliente::factory()->create();
        $imovel = Imovel::factory()->create(['estado' => 'aprovado']);

        $this->actingAs($cliente, 'cliente')
            ->post('/cliente/avaliacoes', [
                'imovel_id' => $imovel->id,
                'estrelas' => 5,
                'comentario' => 'Excelente imóvel, muito bem localizado.',
            ])
            ->assertRedirect()
            ->assertSessionHas('sucesso');

        $this->assertDatabaseHas('avaliacoes', [
            'cliente_id' => $cliente->id,
            'imovel_id' => $imovel->id,
            'estrelas' => 5,
            'estado' => 'pendente',
        ]);
    }

    /** @test */
    public function segunda_avaliacao_no_mesmo_imovel_e_bloqueada()
    {
        $cliente = Cliente::factory()->create();
        $imovel = Imovel::factory()->create(['estado' => 'aprovado']);

        $this->actingAs($cliente, 'cliente')
            ->post('/cliente/avaliacoes', [
                'imovel_id' => $imovel->id,
                'estrelas' => 4,
            ]);

        $this->actingAs($cliente, 'cliente')
            ->from('/cliente/avaliacoes')
            ->post('/cliente/avaliacoes', [
                'imovel_id' => $imovel->id,
                'estrelas' => 2,
            ])
            ->assertSessionHasErrors('imovel_id');

        $this->assertEquals(1, Avaliacao::where('cliente_id', $cliente->id)->count());
    }

    /** @test */
    public function estrelas_fora_do_intervalo_sao_rejeitadas()
    {
        $cliente = Cliente::factory()->create();
        $imovel = Imovel::factory()->create(['estado' => 'aprovado']);

        $this->actingAs($cliente, 'cliente')
            ->from('/cliente/avaliacoes')
            ->post('/cliente/avaliacoes', [
                'imovel_id' => $imovel->id,
                'estrelas' => 9,
            ])
            ->assertSessionHasErrors('estrelas');
    }

    /** @test */
    public function cliente_pode_reenviar_avaliacao_rejeitada()
    {
        $cliente = Cliente::factory()->create();
        $imovel = Imovel::factory()->create(['estado' => 'aprovado']);

        $rejeitada = Avaliacao::create([
            'imovel_id' => $imovel->id,
            'imobiliaria_id' => $imovel->imobiliaria_id,
            'cliente_id' => $cliente->id,
            'autor_nome' => $cliente->nome,
            'autor_email' => $cliente->email,
            'estrelas' => 3,
            'estado' => 'rejeitada',
            'motivo_rejeicao' => 'Conteúdo impróprio',
        ]);

        $this->actingAs($cliente, 'cliente')
            ->post("/cliente/avaliacoes/{$rejeitada->id}/reenviar")
            ->assertRedirect()
            ->assertSessionHas('sucesso');

        // Nova pendente criada
        $this->assertDatabaseHas('avaliacoes', [
            'cliente_id' => $cliente->id,
            'imovel_id' => $imovel->id,
            'estado' => 'pendente',
            'estrelas' => 3,
        ]);
    }

    /** @test */
    public function nao_pode_reenviar_avaliacao_de_outro_cliente()
    {
        $cliente = Cliente::factory()->create();
        $outro = Cliente::factory()->create();
        $imovel = Imovel::factory()->create(['estado' => 'aprovado']);

        $rejeitada = Avaliacao::create([
            'imovel_id' => $imovel->id,
            'imobiliaria_id' => $imovel->imobiliaria_id,
            'cliente_id' => $outro->id,
            'autor_nome' => $outro->nome,
            'autor_email' => $outro->email,
            'estrelas' => 3,
            'estado' => 'rejeitada',
        ]);

        $this->actingAs($cliente, 'cliente')
            ->post("/cliente/avaliacoes/{$rejeitada->id}/reenviar")
            ->assertForbidden();
    }

    /** @test */
    public function cliente_pode_ver_as_suas_avaliacoes()
    {
        $cliente = Cliente::factory()->create();
        $imovel = Imovel::factory()->create(['estado' => 'aprovado', 'titulo' => 'Vivenda avaliada']);

        $this->actingAs($cliente, 'cliente')
            ->post('/cliente/avaliacoes', [
                'imovel_id' => $imovel->id,
                'estrelas' => 5,
                'comentario' => 'Gostei muito.',
            ]);

        $this->get('/cliente/avaliacoes')
            ->assertOk()
            ->assertSee('Vivenda avaliada');
    }
}
