<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Imobiliaria;
use App\Models\Plano;
use App\Models\ImobiliariaPlano;

class ImovelFotosTest extends TestCase
{
    use RefreshDatabase;

    protected function criarImobiliariaComPlano(): Imobiliaria
    {
        $imob = Imobiliaria::create([
            'nome' => 'Imobiliária Teste',
            'email' => 'teste@imob.com',
            'telefone' => '+244921852727',
            'password' => bcrypt('password123'),
            'estado' => 'aprovado',
        ]);

        $plano = Plano::create([
            'nome' => 'Plano Básico',
            'posts_limite' => 10,
            'dias_validade' => 30,
            'preco' => 50000,
            'moeda' => 'Kz',
            'ativo' => true,
        ]);

        ImobiliariaPlano::create([
            'imobiliaria_id' => $imob->id,
            'plano_id' => $plano->id,
            'posts_usados' => 0,
            'data_inicio' => now(),
            'data_expiracao' => now()->addDays(30),
            'ativo' => true,
            'estado' => 'ativa',
        ]);

        return $imob;
    }

    protected function criarFotos(int $quantidade): array
    {
        $fotos = [];
        for ($i = 0; $i < $quantidade; $i++) {
            $fotos[] = UploadedFile::fake()->image("foto{$i}.jpg", 100, 100, 'jpg')->size(100);
        }
        return $fotos;
    }

    /** @test */
    public function imovel_requer_minimo_5_fotos()
    {
        $imob = $this->criarImobiliariaComPlano();
        $this->actingAs($imob, 'imobiliaria');

        $response = $this->post(route('painel.imoveis.store'), [
            'titulo' => 'Imóvel Teste',
            'descricao' => 'Descrição do imóvel teste',
            'preco' => 5000000,
            'moeda' => 'Kz',
            'finalidade' => 'vender',
            'tipo' => 'vivenda',
            'provincia' => 'Luanda',
            'municipio' => 'Maianga',
            'fotos' => $this->criarFotos(3),
        ]);

        $response->assertSessionHasErrors('fotos');
    }

    /** @test */
    public function imovel_aceita_minimo_5_fotos()
    {
        $imob = $this->criarImobiliariaComPlano();
        $this->actingAs($imob, 'imobiliaria');

        Storage::fake('public');

        $response = $this->post(route('painel.imoveis.store'), [
            'titulo' => 'Imóvel Teste',
            'descricao' => 'Descrição do imóvel teste',
            'preco' => 5000000,
            'moeda' => 'Kz',
            'finalidade' => 'vender',
            'tipo' => 'vivenda',
            'provincia' => 'Luanda',
            'municipio' => 'Maianga',
            'fotos' => $this->criarFotos(5),
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('imoveis', [
            'imobiliaria_id' => $imob->id,
            'titulo' => 'Imóvel Teste',
        ]);
    }

    /** @test */
    public function imovel_aceita_maximo_10_fotos()
    {
        $imob = $this->criarImobiliariaComPlano();
        $this->actingAs($imob, 'imobiliaria');

        Storage::fake('public');

        $response = $this->post(route('painel.imoveis.store'), [
            'titulo' => 'Imóvel Teste',
            'descricao' => 'Descrição do imóvel teste',
            'preco' => 5000000,
            'moeda' => 'Kz',
            'finalidade' => 'arrendar',
            'tipo' => 'apartamento',
            'provincia' => 'Luanda',
            'municipio' => 'Maianga',
            'fotos' => $this->criarFotos(10),
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('imoveis', [
            'imobiliaria_id' => $imob->id,
            'titulo' => 'Imóvel Teste',
        ]);
    }

    /** @test */
    public function imovel_rejeita_mais_de_10_fotos()
    {
        $imob = $this->criarImobiliariaComPlano();
        $this->actingAs($imob, 'imobiliaria');

        $response = $this->post(route('painel.imoveis.store'), [
            'titulo' => 'Imóvel Teste',
            'descricao' => 'Descrição do imóvel teste',
            'preco' => 5000000,
            'moeda' => 'Kz',
            'finalidade' => 'vender',
            'tipo' => 'vivenda',
            'provincia' => 'Luanda',
            'municipio' => 'Maianga',
            'fotos' => $this->criarFotos(11),
        ]);

        $response->assertSessionHasErrors('fotos');
    }

    /** @test */
    public function imovel_rejeita_fotos_sem_plano()
    {
        $imob = Imobiliaria::create([
            'nome' => 'Imobiliária Sem Plano',
            'email' => 'semplano@imob.com',
            'telefone' => '+244921852727',
            'password' => bcrypt('password123'),
            'estado' => 'aprovado',
        ]);

        $this->actingAs($imob, 'imobiliaria');

        $response = $this->post(route('painel.imoveis.store'), [
            'titulo' => 'Imóvel Teste',
            'descricao' => 'Descrição do imóvel teste',
            'preco' => 5000000,
            'moeda' => 'Kz',
            'finalidade' => 'vender',
            'tipo' => 'vivenda',
            'provincia' => 'Luanda',
            'municipio' => 'Maianga',
            'fotos' => $this->criarFotos(5),
        ]);

        $response->assertRedirect(route('painel.ativar-plano'));
    }
}
