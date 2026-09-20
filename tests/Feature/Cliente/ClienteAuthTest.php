<?php

namespace Tests\Feature\Cliente;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Cliente;

class ClienteAuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function cliente_pode_registar_nova_conta()
    {
        $response = $this->post('/cliente/registo', [
            'nome' => 'João Silva',
            'email' => 'joao@teste.com',
            'telefone' => '+244921852727',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('sucesso');

        $this->assertDatabaseHas('clientes', [
            'email' => 'joao@teste.com',
            'nome' => 'João Silva',
            'estado' => 'ativo',
        ]);
    }

    /** @test */
    public function cliente_pode_fazer_login()
    {
        $cliente = Cliente::factory()->create([
            'email' => 'teste@cliente.com',
        ]);

        $response = $this->post('/cliente/login', [
            'email' => 'teste@cliente.com',
            'password' => 'cliente1234',
        ]);

        $response->assertRedirect();
        $this->assertAuthenticatedAs($cliente, 'cliente');
    }

    /** @test */
    public function cliente_nao_pode_acessar_dashboard_sem_autenticar()
    {
        $response = $this->get('/cliente/dashboard');

        $response->assertRedirect();
    }

    /** @test */
    public function cliente_pode_ver_dashboard()
    {
        $cliente = Cliente::factory()->create([
            'email' => 'dashboard@teste.com',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($cliente, 'cliente');

        $response = $this->get('/cliente/dashboard');

        $response->assertStatus(200)
            ->assertSee('Bem-vindo');
    }

    /** @test */
    public function cliente_pode_atualizar_perfil()
    {
        $cliente = Cliente::factory()->create([
            'email' => 'perfil@teste.com',
            'password' => bcrypt('password123'),
            'nome' => 'Nome Antigo',
        ]);

        $this->actingAs($cliente, 'cliente');

        $response = $this->put('/cliente/perfil', [
            'nome' => 'Nome Novo',
            'email' => 'perfil@teste.com',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('clientes', [
            'id' => $cliente->id,
            'nome' => 'Nome Novo',
        ]);
    }

    /** @test */
    public function cliente_pode_adicionar_favorito()
    {
        $cliente = Cliente::factory()->create([
            'email' => 'fav@teste.com',
            'password' => bcrypt('password123'),
        ]);

        $imovel = \App\Models\Imovel::factory()->create([
            'titulo' => 'Apartamento Teste',
            'preco' => 50000000,
        ]);

        $this->actingAs($cliente, 'cliente');

        $response = $this->post("/cliente/favoritos/{$imovel->id}");

        $response->assertRedirect();

        $this->assertDatabaseHas('cliente_favoritos', [
            'cliente_id' => $cliente->id,
            'imovel_id' => $imovel->id,
        ]);
    }

    /** @test */
    public function cliente_pode_agendar_visita()
    {
        $cliente = Cliente::factory()->create([
            'email' => 'visita@teste.com',
            'password' => bcrypt('password123'),
        ]);

        $imovel = \App\Models\Imovel::factory()->create([
            'titulo' => 'Casa Teste',
            'preco' => 80000000,
        ]);

        $this->actingAs($cliente, 'cliente');

        $response = $this->post("/cliente/visitas/{$imovel->id}", [
            'data_visita' => date('Y-m-d', strtotime('+7 days')),
            'telefone' => '+244921852727',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('visitas', [
            'cliente_id' => $cliente->id,
            'imovel_id' => $imovel->id,
            'estado' => 'pendente',
        ]);
    }

    /** @test */
    public function cliente_pode_enviar_mensagem()
    {
        $cliente = Cliente::factory()->create([
            'email' => 'msg@teste.com',
            'password' => bcrypt('password123'),
        ]);

        $imovel = \App\Models\Imovel::factory()->create([
            'titulo' => 'Imóvel Teste',
        ]);

        $this->actingAs($cliente, 'cliente');

        $response = $this->post("/cliente/imoveis/{$imovel->id}/mensagem", [
            'texto' => 'Olá, gostaria de mais informações sobre este imóvel.',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('mensagens', [
            'cliente_id' => $cliente->id,
            'imovel_id' => $imovel->id,
            'origem' => 'cliente',
        ]);
    }

    /** @test */
    public function cliente_pode_ver_mensagens()
    {
        $cliente = Cliente::factory()->create([
            'email' => 'msgs@teste.com',
            'password' => bcrypt('password123'),
        ]);

        $imovel = \App\Models\Imovel::factory()->create([
            'titulo' => 'Imóvel Teste',
        ]);

        $mensagem = \App\Models\Mensagem::factory()->create([
            'cliente_id' => $cliente->id,
            'imovel_id' => $imovel->id,
            'nome' => 'Teste',
            'contacto' => '921852727',
            'texto' => 'Mensagem de teste',
            'origem' => 'cliente',
        ]);

        $this->actingAs($cliente, 'cliente');

        $response = $this->get('/cliente/mensagens');

        $response->assertStatus(200)
            ->assertSee('Mensagem de teste');
    }

    /** @test */
    public function cliente_nao_ativo_nao_pode_login()
    {
        $cliente = Cliente::factory()->create([
            'email' => 'inativo@teste.com',
            'password' => bcrypt('password123'),
            'estado' => 'suspenso',
        ]);

        $response = $this->post('/cliente/login', [
            'email' => 'inativo@teste.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }
}
