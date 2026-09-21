<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Fatura;
use App\Models\Imobiliaria;
use App\Models\ImobiliariaPlano;
use App\Models\Plano;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FaturaReciboTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_gerar_pdf_recibo_conteudo_correto(): void
    {
        $imob = Imobiliaria::where('estado', 'aprovada')->first();
        $plano = Plano::first();
        $admin = Admin::where('email', 'admin@qnbangola.com')->first();

        $subscricao = ImobiliariaPlano::create([
            'imobiliaria_id' => $imob->id,
            'plano_id' => $plano->id,
            'posts_usados' => 0,
            'data_inicio' => null,
            'data_expiracao' => null,
            'ativo' => false,
            'estado' => 'pendente',
        ]);

        $pagamento = \App\Models\Pagamento::create([
            'subscricao_id' => $subscricao->id,
            'imobiliaria_id' => $imob->id,
            'valor' => $plano->preco,
            'moeda' => 'Kz',
            'metodo' => 'transferencia',
            'estado' => 'confirmado',
        ]);

        $fatura = Fatura::create([
            'numero' => Fatura::proximoNumero(),
            'pagamento_id' => $pagamento->id,
            'imobiliaria_id' => $imob->id,
            'valor' => $plano->preco,
            'moeda' => 'Kz',
            'iva' => 0,
            'total' => $plano->preco,
            'subtotal' => $plano->preco,
            'desconto' => 0,
            'retencao' => 0,
            'estado' => 'aguarda_aprovacao',
            'emitida_em' => now(),
            'comprovativo_path' => 'comprovativos/test.jpg',
            'comprovativo_enviado_em' => now(),
            'comprovativo_por' => $imob->id,
        ]);

        $service = app(\App\Services\FaturaService::class);
        $numeroRecibo = Fatura::proximoNumeroRecibo();
        $fatura->update(['recibo_numero' => $numeroRecibo]);
        $path = $service->gerarPdfRecibo($fatura);

        $this->assertFileExists(storage_path('app/public/' . $path));
        $this->assertStringContainsString('REC', $numeroRecibo);

        $fatura->refresh();
        $this->assertEquals($numeroRecibo, $fatura->recibo_numero);
        $this->assertEquals($path, $fatura->recibo_pdf_path);
        $this->assertNotNull($fatura->recibo_emitido_em);
    }

    public function test_download_recibo_retorna_pdf(): void
    {
        $imob = Imobiliaria::where('estado', 'aprovada')->first();

        $fatura = Fatura::where('imobiliaria_id', $imob->id)->first();
        if (!$fatura || !$fatura->recibo_pdf_path) {
            $this->markTestSkipped('Fatura sem recibo disponível.');
        }

        $response = $this->actingAs($imob, 'imobiliaria')
            ->get(route('painel.faturas.recibo', $fatura));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_proximo_numero_recibo_formato_correto(): void
    {
        $numero = Fatura::proximoNumeroRecibo();
        $this->assertMatchesRegularExpression('/^REC \d{4}\/\d{4}$/', $numero);
    }

    public function test_registrar_email_cria_registro(): void
    {
        $fatura = Fatura::first();
        if (!$fatura) {
            $this->markTestSkipped('Sem faturas.');
        }

        $service = app(\App\Services\FaturaService::class);
        $emailLog = $service->registrarEmail($fatura->id, 'emitida', $fatura->imobiliaria_id, 'test@test.com');

        $this->assertNotNull($emailLog);
        $this->assertEquals('emitida', $emailLog->evento);
        $this->assertEquals($fatura->id, $emailLog->fatura_id);
    }
}
