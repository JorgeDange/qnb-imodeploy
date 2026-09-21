<?php

namespace Tests\Feature\Cliente;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Cliente;
use App\Models\Imovel;
use App\Models\ClienteFavorito;

class ClienteFavoritoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function cliente_pode_ver_favoritos()
    {
        $cliente = Cliente::factory()->create();

        $this->actingAs($cliente, 'cliente')
            ->get('/cliente/favoritos')
            ->assertOk();
    }

    /** @test */
    public function cliente_pode_adicionar_favorito()
    {
        $cliente = Cliente::factory()->create();
        $imovel = Imovel::factory()->create();

        $this->actingAs($cliente, 'cliente')
            ->post("/cliente/favoritos/{$imovel->id}")
            ->assertRedirect();

        $this->assertDatabaseHas('cliente_favoritos', [
            'cliente_id' => $cliente->id,
            'imovel_id' => $imovel->id,
        ]);
    }

    /** @test */
    public function favorito_duplicado_nao_e_criado()
    {
        $cliente = Cliente::factory()->create();
        $imovel = Imovel::factory()->create();

        $this->actingAs($cliente, 'cliente')
            ->post("/cliente/favoritos/{$imovel->id}");

        $this->actingAs($cliente, 'cliente')
            ->post("/cliente/favoritos/{$imovel->id}");

        $this->assertEquals(1, ClienteFavorito::where('cliente_id', $cliente->id)->count());
    }

    /** @test */
    public function cliente_pode_remover_favorito()
    {
        $cliente = Cliente::factory()->create();
        $imovel = Imovel::factory()->create();

        $this->actingAs($cliente, 'cliente')
            ->post("/cliente/favoritos/{$imovel->id}");

        $this->actingAs($cliente, 'cliente')
            ->delete("/cliente/favoritos/{$imovel->id}")
            ->assertRedirect();

        $this->assertDatabaseMissing('cliente_favoritos', [
            'cliente_id' => $cliente->id,
            'imovel_id' => $imovel->id,
        ]);
    }

    /** @test */
    public function favoritos_de_clientes_diferentes_sao_independentes()
    {
        $a = Cliente::factory()->create();
        $b = Cliente::factory()->create();
        $imovel = Imovel::factory()->create();

        $this->actingAs($a, 'cliente')
            ->post("/cliente/favoritos/{$imovel->id}");

        $this->actingAs($b, 'cliente')
            ->post("/cliente/favoritos/{$imovel->id}");

        $this->assertEquals(2, ClienteFavorito::where('imovel_id', $imovel->id)->count());
    }

    /** @test */
    public function nao_autenticado_e_redirecionado()
    {
        $imovel = Imovel::factory()->create();

        $this->post("/cliente/favoritos/{$imovel->id}")
            ->assertRedirect();
    }
}
