<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Imobiliaria;
use App\Models\Plano;
use App\Models\Fatura;
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
    public function imobiliaria_pode_aceder_pagina_planos()
    {
        $imob = $this->criarImobiliaria();
        $this->actingAs($imob, 'imobiliaria');

        $response = $this->get(route('painel.ativar-plano'));
        $response->assertStatus(200);
        $response->assertViewIs('painel.ativar-plano');
    }

    /** @test */
    public function imobiliaria_pode_criar_fatura_ao_selecionar_plano()
    {
        $imob = $this->criarImobiliaria();
        $plano = $this->criarPlano();
        $this->actingAs($imob, 'imobiliaria');

        $response = $this->post(route('painel.ativar-plano.criar'), [
            'plano_id' => $plano->id,
        ]);

        $fatura = Fatura::where('imobiliaria_id', $imob->id)->first();
        $response->assertRedirect(route('painel.faturas.show', $fatura));

        $this->assertDatabaseHas('faturas', [
            'imobiliaria_id' => $imob->id,
            'estado' => 'pendente',
        ]);
        $this->assertDatabaseHas('imobiliaria_plano', [
            'imobiliaria_id' => $imob->id,
            'plano_id' => $plano->id,
            'ativo' => false,
            'estado' => 'pendente',
        ]);
    }

    /** @test */
    public function plano_inexistente_e_rejeitado()
    {
        $imob = $this->criarImobiliaria();
        $this->actingAs($imob, 'imobiliaria');

        $response = $this->post(route('painel.ativar-plano.criar'), [
            'plano_id' => 9999,
        ]);

        $response->assertSessionHasErrors('plano_id');
    }

    /** @test */
    public function imobiliaria_pode_ver_lista_faturas()
    {
        $imob = $this->criarImobiliaria();
        $this->actingAs($imob, 'imobiliaria');

        $response = $this->get(route('painel.faturas'));
        $response->assertStatus(200);
        $response->assertViewIs('painel.faturas.index');
    }

    /** @test */
    public function imobiliaria_pode_ver_detalhe_fatura()
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

        $fatura = Fatura::create([
            'numero' => Fatura::proximoNumero(),
            'pagamento_id' => $pagamento->id,
            'imobiliaria_id' => $imob->id,
            'valor' => $plano->preco,
            'moeda' => $plano->moeda,
            'iva' => 0,
            'subtotal' => $plano->preco,
            'desconto' => 0,
            'retencao' => 0,
            'total' => $plano->preco,
            'estado' => 'pendente',
            'emitida_em' => now(),
        ]);

        $response = $this->get(route('painel.faturas.show', $fatura));
        $response->assertStatus(200);
        $response->assertViewIs('painel.faturas.show');
    }
}
