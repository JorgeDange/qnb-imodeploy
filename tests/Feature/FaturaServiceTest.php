<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\EmpresaConfig;
use App\Models\Fatura;
use App\Models\FaturaLinha;
use App\Models\Imobiliaria;
use App\Models\ImobiliariaPlano;
use App\Models\Pagamento;
use App\Models\Plano;
use App\Services\EmpresaConfigService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FaturaServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_empresa_config_service_snapshot(): void
    {
        $service = app(EmpresaConfigService::class);
        $snapshot = $service->snapshot();

        $this->assertArrayHasKey('empresa_nome', $snapshot);
        $this->assertArrayHasKey('empresa_nif', $snapshot);
        $this->assertArrayHasKey('banco_nome', $snapshot);
        $this->assertNotEmpty($snapshot['empresa_nome']);
    }

    public function test_empresa_config_service_config_fatura(): void
    {
        $service = app(EmpresaConfigService::class);
        $config = $service->configFatura();

        $this->assertArrayHasKey('iva_percentagem', $config);
        $this->assertArrayHasKey('retencao_percentagem', $config);
        $this->assertArrayHasKey('dias_vencimento', $config);
        $this->assertIsFloat($config['iva_percentagem']);
    }

    public function test_empresa_config_service_todas(): void
    {
        $service = app(EmpresaConfigService::class);
        $todas = $service->todas();

        $this->assertIsArray($todas);
        $this->assertArrayHasKey('identificacao', $todas);
        $this->assertArrayHasKey('bancario', $todas);
        $this->assertArrayHasKey('fatura', $todas);
    }

    public function test_empresa_config_service_set_get(): void
    {
        $service = app(EmpresaConfigService::class);

        $service->set('teste_service_chave', 'teste_service_valor', 'teste');
        $this->assertEquals('teste_service_valor', $service->get('teste_service_chave'));

        $service->set('teste_service_chave', 'actualizado', 'teste');
        $this->assertEquals('actualizado', $service->get('teste_service_chave'));
    }

    public function test_empresa_config_service_atualizar_grupo(): void
    {
        $service = app(EmpresaConfigService::class);

        $service->atualizarGrupo('teste_grupo', [
            'chave_a' => 'valor_a',
            'chave_b' => 'valor_b',
        ]);

        $this->assertEquals('valor_a', $service->get('chave_a'));
        $this->assertEquals('valor_b', $service->get('chave_b'));
    }

    public function test_fatura_numero_sequencial(): void
    {
        $imob = Imobiliaria::first();
        $plano = Plano::first();

        $subscricao = ImobiliariaPlano::create([
            'imobiliaria_id' => $imob->id,
            'plano_id' => $plano->id,
            'posts_usados' => 0,
            'data_inicio' => now(),
            'data_expiracao' => now()->addDays(30),
            'ativo' => true,
            'estado' => 'ativa',
        ]);

        $pagamento = Pagamento::create([
            'subscricao_id' => $subscricao->id,
            'imobiliaria_id' => $imob->id,
            'valor' => $plano->preco,
            'moeda' => 'Kz',
            'metodo' => 'transferencia',
            'estado' => 'confirmado',
        ]);

        $ano = date('Y');
        $numero1 = Fatura::proximoNumero();
        $this->assertEquals("FT {$ano}/0001", $numero1);

        Fatura::create([
            'numero' => $numero1,
            'pagamento_id' => $pagamento->id,
            'imobiliaria_id' => $imob->id,
            'valor' => 10000,
            'moeda' => 'Kz',
            'iva' => 0,
            'total' => 10000,
            'subtotal' => 10000,
            'desconto' => 0,
            'retencao' => 0,
        ]);

        $numero2 = Fatura::proximoNumero();
        $this->assertEquals("FT {$ano}/0002", $numero2);
    }

    public function test_fatura_linhas_relationship(): void
    {
        $imob = Imobiliaria::first();
        $plano = Plano::first();

        $subscricao = ImobiliariaPlano::create([
            'imobiliaria_id' => $imob->id,
            'plano_id' => $plano->id,
            'posts_usados' => 0,
            'data_inicio' => now(),
            'data_expiracao' => now()->addDays(30),
            'ativo' => true,
            'estado' => 'ativa',
        ]);

        $pagamento = Pagamento::create([
            'subscricao_id' => $subscricao->id,
            'imobiliaria_id' => $imob->id,
            'valor' => $plano->preco,
            'moeda' => 'Kz',
            'metodo' => 'transferencia',
            'estado' => 'confirmado',
        ]);

        $fatura = Fatura::create([
            'numero' => 'FT TESTE/0001',
            'pagamento_id' => $pagamento->id,
            'imobiliaria_id' => $imob->id,
            'valor' => 15000,
            'moeda' => 'Kz',
            'iva' => 2100,
            'total' => 17100,
            'subtotal' => 15000,
            'desconto' => 0,
            'retencao' => 0,
        ]);

        FaturaLinha::create([
            'fatura_id' => $fatura->id,
            'descricao' => 'Servico de teste',
            'quantidade' => 1,
            'valor_unitario' => 15000,
            'subtotal' => 15000,
        ]);

        $fatura->load('linhas');
        $this->assertCount(1, $fatura->linhas);
        $this->assertEquals('Servico de teste', $fatura->linhas->first()->descricao);
    }
}
