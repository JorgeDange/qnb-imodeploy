<?php

namespace Tests\Feature\Cliente;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Cliente;

class ClientePesquisaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function cliente_pode_guardar_pesquisa()
    {
        $cliente = Cliente::factory()->create();

        $this->actingAs($cliente, 'cliente')
            ->post('/cliente/pesquisas', ['termo' => 'apartamento luanda'])
            ->assertRedirect()
            ->assertSessionHas('sucesso');

        $this->assertDatabaseHas('cliente_pesquisas', [
            'cliente_id' => $cliente->id,
            'termo' => 'apartamento luanda',
        ]);
    }

    /** @test */
    public function pesquisa_duplicada_da_erro_de_validacao_nao_500()
    {
        $cliente = Cliente::factory()->create();

        $this->actingAs($cliente, 'cliente')
            ->post('/cliente/pesquisas', ['termo' => 'apartamento luanda']);

        // Repetição não deve lançar exceção (500), deve voltar com erro de validação
        $this->actingAs($cliente, 'cliente')
            ->from('/cliente/pesquisas')
            ->post('/cliente/pesquisas', ['termo' => 'apartamento luanda'])
            ->assertSessionHasErrors('termo');
    }

    /** @test */
    public function mesmo_termo_de_clientes_diferentes_e_permitido()
    {
        $a = Cliente::factory()->create();
        $b = Cliente::factory()->create();

        $this->actingAs($a, 'cliente')
            ->post('/cliente/pesquisas', ['termo' => 'vivenda']);
        $this->actingAs($b, 'cliente')
            ->post('/cliente/pesquisas', ['termo' => 'vivenda']);

        $this->assertEquals(2, \App\Models\ClientePesquisa::where('termo', 'vivenda')->count());
    }
}
