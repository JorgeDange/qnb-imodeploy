<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\Imobiliaria;
use App\Models\Plano;
use App\Models\ImobiliariaPlano;
use App\Models\Pagamento;

class PagamentoTest extends TestCase
{
    use RefreshDatabase;

    protected function criarImobiliaria(): Imobiliaria
    {
        return Imobiliaria::create([
            'nome' => 'Imobiliária Teste',
            'email' => 'teste@imob.com',
            'telefone' => '+244921852727',
            'password' => bcrypt('password123'),
            'estado' => 'aprovado',
        ]);
    }

    protected function criarPlano(): Plano
    {
        return Plano::create([
            'nome' => 'Plano Básico',
            'posts_limite' => 10,
            'dias_validade' => 30,
            'preco' => 50000,
            'moeda' => 'Kz',
            'ativo' => true,
        ]);
    }

    /** @test */
    public function imobiliaria_pode_aceder_formulario_pagamento()
    {
        $imob = $this->criarImobiliaria();
        $this->actingAs($imob, 'imobiliaria');

        $response = $this->get(route('painel.pagamento.novo'));
        $response->assertStatus(200);
        $response->assertViewIs('painel.pagamento.novo');
    }

    /** @test */
    public function imobiliaria_pode_submeter_pagamento()
    {
        $imob = $this->criarImobiliaria();
        $plano = $this->criarPlano();
        $this->actingAs($imob, 'imobiliaria');

        $response = $this->post(route('painel.pagamento.salvar'), [
            'plano_id' => $plano->id,
            'metodo' => 'transferencia',
            'referencia' => 'REF-12345',
        ]);

        $response->assertRedirect(route('painel.pagamento.confirmado'));
        $this->assertDatabaseHas('pagamentos', [
            'imobiliaria_id' => $imob->id,
            'estado' => 'pendente',
            'metodo' => 'transferencia',
        ]);
        $this->assertDatabaseHas('imobiliaria_plano', [
            'imobiliaria_id' => $imob->id,
            'plano_id' => $plano->id,
            'ativo' => false,
            'estado' => 'pendente',
        ]);
    }

    /** @test */
    public function imobiliaria_pode_submeter_pagamento_com_comprovativo()
    {
        $imob = $this->criarImobiliaria();
        $plano = $this->criarPlano();
        $this->actingAs($imob, 'imobiliaria');

        $comprovativo = UploadedFile::fake()->image('comprovativo.jpg', 100, 100, 'jpg')->size(100);

        $response = $this->post(route('painel.pagamento.salvar'), [
            'plano_id' => $plano->id,
            'metodo' => 'multicaixa',
            'referencia' => 'MC-99999',
            'comprovativo' => $comprovativo,
        ]);

        $response->assertRedirect(route('painel.pagamento.confirmado'));
        $this->assertDatabaseHas('pagamentos', [
            'imobiliaria_id' => $imob->id,
            'metodo' => 'multicaixa',
        ]);
    }

    /** @test */
    public function metodo_pagamento_invalido_e_rejeitado()
    {
        $imob = $this->criarImobiliaria();
        $plano = $this->criarPlano();
        $this->actingAs($imob, 'imobiliaria');

        $response = $this->post(route('painel.pagamento.salvar'), [
            'plano_id' => $plano->id,
            'metodo' => 'invalido',
        ]);

        $response->assertSessionHasErrors('metodo');
    }

    /** @test */
    public function plano_inexistente_e_rejeitado()
    {
        $imob = $this->criarImobiliaria();
        $this->actingAs($imob, 'imobiliaria');

        $response = $this->post(route('painel.pagamento.salvar'), [
            'plano_id' => 9999,
            'metodo' => 'transferencia',
        ]);

        $response->assertSessionHasErrors('plano_id');
    }

    /** @test */
    public function imobiliaria_pode_ver_historico_pagamentos()
    {
        $imob = $this->criarImobiliaria();
        $this->actingAs($imob, 'imobiliaria');

        $response = $this->get(route('painel.pagamentos'));
        $response->assertStatus(200);
        $response->assertViewIs('painel.pagamentos.index');
    }

    /** @test */
    public function imobiliaria_pode_ver_detalhe_pagamento()
    {
        $imob = $this->criarImobiliaria();
        $plano = $this->criarPlano();
        $this->actingAs($imob, 'imobiliaria');

        $subscricao = ImobiliariaPlano::create([
            'imobiliaria_id' => $imob->id,
            'plano_id' => $plano->id,
            'posts_usados' => 0,
            'ativo' => false,
            'estado' => 'pendente',
        ]);

        $pagamento = Pagamento::create([
            'subscricao_id' => $subscricao->id,
            'imobiliaria_id' => $imob->id,
            'valor' => $plano->preco,
            'moeda' => $plano->moeda,
            'metodo' => 'transferencia',
            'estado' => 'pendente',
        ]);

        $response = $this->get(route('painel.pagamentos.show', $pagamento->id));
        $response->assertStatus(200);
        $response->assertViewIs('painel.pagamentos.show');
    }
}
