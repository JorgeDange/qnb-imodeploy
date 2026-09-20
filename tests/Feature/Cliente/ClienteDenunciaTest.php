<?php

namespace Tests\Feature\Cliente;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Cliente;
use App\Models\Imovel;

class ClienteDenunciaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function cliente_pode_criar_denuncia()
    {
        $cliente = Cliente::factory()->create();
        $imovel = Imovel::factory()->create(['estado' => 'aprovado']);

        $this->actingAs($cliente, 'cliente')
            ->post('/cliente/denuncias', [
                'imovel_id' => $imovel->id,
                'motivo' => 'informacao_falsa',
                'descricao' => 'As fotos não correspondem ao imóvel real.',
            ])
            ->assertRedirect()
            ->assertSessionHas('sucesso');

        $this->assertDatabaseHas('denuncias', [
            'cliente_id' => $cliente->id,
            'imovel_id' => $imovel->id,
            'motivo' => 'informacao_falsa',
            'estado' => 'pendente',
        ]);
    }

    /** @test */
    public function denuncia_preenche_autor_automaticamente()
    {
        $cliente = Cliente::factory()->create([
            'nome' => 'João Silva',
            'email' => 'joao@teste.com',
            'telefone' => '+244921852727',
        ]);
        $imovel = Imovel::factory()->create(['estado' => 'aprovado']);

        $this->actingAs($cliente, 'cliente')
            ->post('/cliente/denuncias', [
                'imovel_id' => $imovel->id,
                'motivo' => 'spam',
                'descricao' => 'Conteúdo repetido várias vezes.',
            ]);

        $this->assertDatabaseHas('denuncias', [
            'cliente_id' => $cliente->id,
            'autor_nome' => 'João Silva',
            'autor_email' => 'joao@teste.com',
        ]);
    }

    /** @test */
    public function motivo_invalido_e_rejeitado()
    {
        $cliente = Cliente::factory()->create();
        $imovel = Imovel::factory()->create(['estado' => 'aprovado']);

        $this->actingAs($cliente, 'cliente')
            ->from('/cliente/denuncias')
            ->post('/cliente/denuncias', [
                'imovel_id' => $imovel->id,
                'motivo' => 'motivo_inexistente',
                'descricao' => 'Descrição suficientemente longa.',
            ])
            ->assertSessionHasErrors('motivo');

        $this->assertDatabaseMissing('denuncias', [
            'imovel_id' => $imovel->id,
            'cliente_id' => $cliente->id,
        ]);
    }

    /** @test */
    public function descricao_curta_e_rejeitada()
    {
        $cliente = Cliente::factory()->create();
        $imovel = Imovel::factory()->create(['estado' => 'aprovado']);

        $this->actingAs($cliente, 'cliente')
            ->from('/cliente/denuncias')
            ->post('/cliente/denuncias', [
                'imovel_id' => $imovel->id,
                'motivo' => 'spam',
                'descricao' => 'curto',
            ])
            ->assertSessionHasErrors('descricao');
    }

    /** @test */
    public function cliente_pode_ver_as_suas_denuncias()
    {
        $cliente = Cliente::factory()->create();
        $imovel = Imovel::factory()->create(['estado' => 'aprovado', 'titulo' => 'Apartamento denúncia']);

        $this->actingAs($cliente, 'cliente')
            ->post('/cliente/denuncias', [
                'imovel_id' => $imovel->id,
                'motivo' => 'outro',
                'descricao' => 'Outro problema qualquer com o imóvel.',
            ]);

        $this->get('/cliente/denuncias')
            ->assertOk()
            ->assertSee('Apartamento denúncia');
    }

    /** @test */
    public function requer_autenticacao()
    {
        $imovel = Imovel::factory()->create(['estado' => 'aprovado']);

        $this->post('/cliente/denuncias', [
            'imovel_id' => $imovel->id,
            'motivo' => 'spam',
            'descricao' => 'Tentativa sem login com descrição.',
        ])->assertRedirect();

        $this->assertDatabaseMissing('denuncias', [
            'imovel_id' => $imovel->id,
        ]);
    }
}
