<?php

namespace Tests\Feature;

use App\Models\Fatura;
use App\Models\Imobiliaria;
use App\Models\ImobiliariaPlano;
use App\Models\Plano;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FaturaPainelHttpTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    // ==================== PAINEL ROUTES (qnb-imobiliaria) ====================

    public function test_painel_index_faturas(): void
    {
        $imob = Imobiliaria::where('estado', 'aprovada')->first();

        $response = $this->actingAs($imob, 'imobiliaria')
            ->get(route('painel.faturas'));

        $response->assertStatus(200);
        $response->assertSee('Faturas');
    }

    public function test_painel_show_fatura(): void
    {
        $imob = Imobiliaria::where('estado', 'aprovada')->first();
        $fatura = Fatura::where('imobiliaria_id', $imob->id)->first();

        if (!$fatura) {
            $this->markTestSkipped('Sem faturas para esta imobiliária.');
        }

        $response = $this->actingAs($imob, 'imobiliaria')
            ->get(route('painel.faturas.show', $fatura));

        $response->assertStatus(200);
        $response->assertSee($fatura->numero);
    }

    public function test_painel_download_fatura(): void
    {
        $imob = Imobiliaria::where('estado', 'aprovada')->first();
        $fatura = Fatura::where('imobiliaria_id', $imob->id)->first();

        if (!$fatura) {
            $this->markTestSkipped('Sem faturas.');
        }

        $response = $this->actingAs($imob, 'imobiliaria')
            ->get(route('painel.faturas.download', $fatura));

        $response->assertStatus(200);
    }

    public function test_painel_submeter_comprovativo(): void
    {
        Storage::fake('public');
        $imob = Imobiliaria::where('estado', 'aprovada')->first();
        $plano = Plano::first();

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

        $comprovativo = UploadedFile::fake()->image('comprovativo.jpg', 100, 100, 'jpg', 100);

        $response = $this->actingAs($imob, 'imobiliaria')
            ->post(route('painel.faturas.comprovativo', $fatura), [
                'comprovativo' => $comprovativo,
            ]);

        $response->assertRedirect();
        $fatura->refresh();
        $this->assertEquals('aguarda_aprovacao', $fatura->estado);
    }

    public function test_painel_nao_pode_aprovar_fatura(): void
    {
        $imob = Imobiliaria::where('estado', 'aprovada')->first();
        $fatura = Fatura::where('estado', 'aguarda_aprovacao')->first();

        if (!$fatura) {
            $this->markTestSkipped('Sem faturas aguardando aprovação.');
        }

        $response = $this->actingAs($imob, 'imobiliaria')
            ->post(route('admin.faturas.aprovar', $fatura));

        $response->assertStatus(403);
    }
}
