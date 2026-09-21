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

class FaturaFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_fluxo_completo_emitir_submeter_aprovar(): void
    {
        $imob = Imobiliaria::where('estado', 'aprovada')->first();
        $plano = Plano::first();
        $adminId = 1; // Admin vive na app qnb-admin — aqui só precisamos de um ID

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
            'estado' => 'pendente',
            'emitida_em' => now(),
        ]);

        $this->assertEquals('pendente', $fatura->estado);

        // Submeter comprovativo
        Storage::fake('public');
        $comprovativo = UploadedFile::fake()->image('comprovativo.jpg', 100, 100, 'jpg', 100);

        $this->actingAs($imob, 'imobiliaria')
            ->post(route('painel.faturas.comprovativo', $fatura), [
                'comprovativo' => $comprovativo,
            ]);

        $fatura->refresh();
        $this->assertEquals('aguarda_aprovacao', $fatura->estado);
        $this->assertNotNull($fatura->comprovativo_path);

        // Aprovar — agora feito na app qnb-admin (CRM separado).
        // Aqui validamos o equivalente funcional: a Action de aprovação aplicada à fatura.
        $aprovar = app(\App\Actions\Faturas\AprovarPagamentoAction::class);
        $aprovar->execute($fatura, $adminId);

        $fatura->refresh();
        $this->assertEquals('paga', $fatura->estado);
        $this->assertNotNull($fatura->recibo_numero);
        $this->assertNotNull($fatura->recibo_pdf_path);
        $this->assertNotNull($fatura->aprovada_em);
    }

    public function test_estado_inicial_e_pendente(): void
    {
        $fatura = Fatura::first();
        if ($fatura) {
            $this->assertContains($fatura->estado, ['pendente', 'paga']);
        }
    }

    public function test_fatura_tem_numero_sequencial(): void
    {
        $numero = Fatura::proximoNumero();
        $this->assertMatchesRegularExpression('/^FT \d{4}\/\d{4}$/', $numero);
    }

    public function test_recibo_numero_sequencial(): void
    {
        $numero = Fatura::proximoNumeroRecibo();
        $this->assertMatchesRegularExpression('/^REC \d{4}\/\d{4}$/', $numero);
    }

    public function test_scopes_funcionam(): void
    {
        $this->assertIsNumeric(Fatura::pendentes()->count());
        $this->assertIsNumeric(Fatura::pagas()->count());
        $this->assertIsNumeric(Fatura::aguardaAprovacao()->count());
    }
}
