<?php

namespace Tests\Feature\Cliente;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Cliente;
use App\Models\Imovel;
use App\Models\Visita;

class ClienteVisitaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function cliente_pode_ver_suas_visitas()
    {
        $cliente = Cliente::factory()->create();

        $this->actingAs($cliente, 'cliente')
            ->get('/cliente/visitas')
            ->assertOk();
    }

    /** @test */
    public function cliente_pode_agendar_visita()
    {
        $cliente = Cliente::factory()->create();
        $imovel = Imovel::factory()->create();

        $this->actingAs($cliente, 'cliente')
            ->post("/cliente/visitas/{$imovel->id}", [
                'data_visita' => now()->addDays(7)->format('Y-m-d'),
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('visitas', [
            'cliente_id' => $cliente->id,
            'imovel_id' => $imovel->id,
            'estado' => 'pendente',
        ]);
    }

    /** @test */
    public function cliente_pode_cancelar_visita()
    {
        $cliente = Cliente::factory()->create();
        $imovel = Imovel::factory()->create();

        $this->actingAs($cliente, 'cliente')
            ->post("/cliente/visitas/{$imovel->id}", [
                'data_visita' => now()->addDays(10)->format('Y-m-d'),
            ]);

        $visita = Visita::where('cliente_id', $cliente->id)->first();

        $this->actingAs($cliente, 'cliente')
            ->post("/cliente/visitas/{$visita->id}/cancelar")
            ->assertRedirect();

        $visita->refresh();
        $this->assertEquals('cancelada', $visita->estado);
    }

    /** @test */
    public function cliente_nao_pode_cancelar_visita_de_outro_cliente()
    {
        $a = Cliente::factory()->create();
        $b = Cliente::factory()->create();
        $imovel = Imovel::factory()->create();

        $this->actingAs($a, 'cliente')
            ->post("/cliente/visitas/{$imovel->id}", [
                'data_visita' => now()->addDays(5)->format('Y-m-d'),
            ]);

        $visita = Visita::where('cliente_id', $a->id)->first();

        $this->actingAs($b, 'cliente')
            ->post("/cliente/visitas/{$visita->id}/cancelar")
            ->assertForbidden();
    }

    /** @test */
    public function nao_autenticado_e_redirecionado()
    {
        $imovel = Imovel::factory()->create();

        $this->post("/cliente/visitas/{$imovel->id}", [
            'data_visita' => now()->addDays(7)->format('Y-m-d'),
        ])->assertRedirect();
    }
}
