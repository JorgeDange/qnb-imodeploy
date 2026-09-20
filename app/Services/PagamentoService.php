<?php

namespace App\Services;

use App\Jobs\SendPagamentoRecebidoEmail;
use App\Models\Fatura;
use App\Models\ImobiliariaPlano;
use App\Models\Plano;
use App\Models\Imobiliaria;
use Illuminate\Http\UploadedFile;

class PagamentoService
{
    public function criarPagamento(
        Imobiliaria $imobiliaria,
        Plano $plano,
        string $metodo,
        ?string $referencia,
        ?UploadedFile $comprovativo,
    ): ImobiliariaPlano {
        // Criar subscricao pendente
        $subscricao = ImobiliariaPlano::create([
            'imobiliaria_id' => $imobiliaria->id,
            'plano_id' => $plano->id,
            'posts_usados' => 0,
            'data_inicio' => null,
            'data_expiracao' => null,
            'ativo' => false,
            'estado' => 'pendente',
        ]);

        // Upload comprovativo
        $caminhoComprovativo = null;
        if ($comprovativo) {
            $caminhoComprovativo = $comprovativo->store('pagamentos/comprovativos', 'public');
        }

        // Criar pagamento
        $pagamento = new \App\Models\Pagamento();
        $pagamento->subscricao_id = $subscricao->id;
        $pagamento->imobiliaria_id = $imobiliaria->id;
        $pagamento->valor = $plano->preco;
        $pagamento->moeda = $plano->moeda;
        $pagamento->metodo = $metodo;
        $pagamento->referencia = $referencia;
        $pagamento->comprovativo = $caminhoComprovativo;
        $pagamento->estado = 'pendente';
        $pagamento->save();

        // Notificar admin
        SendPagamentoRecebidoEmail::dispatch($pagamento);

        return $subscricao;
    }

    public function confirmarPagamento(\App\Models\Pagamento $pagamento, int $adminId): Fatura
    {
        $pagamento->update([
            'estado' => 'confirmado',
            'confirmado_por' => $adminId,
            'confirmado_em' => now(),
        ]);

        // Gerar fatura
        $fatura = Fatura::create([
            'numero' => Fatura::proximoNumero(),
            'pagamento_id' => $pagamento->id,
            'imobiliaria_id' => $pagamento->imobiliaria_id,
            'valor' => $pagamento->valor,
            'moeda' => $pagamento->moeda,
            'iva' => 0,
            'total' => $pagamento->valor,
        ]);

        // Gerar PDF da fatura
        $invoiceService = new InvoiceService();
        $invoiceService->gerarPdf($fatura);

        // Ativar subscricao
        $subscricao = $pagamento->subscricao;
        if ($subscricao) {
            $plano = $subscricao->plano;
            $subscricao->update([
                'data_inicio' => now()->toDateString(),
                'data_expiracao' => now()->addDays($plano->dias_validade)->toDateString(),
                'ativo' => true,
                'estado' => 'ativa',
            ]);

            // Desativar plano anterior da imobiliaria
            ImobiliariaPlano::where('imobiliaria_id', $pagamento->imobiliaria_id)
                ->where('id', '!=', $subscricao->id)
                ->where('ativo', true)
                ->update(['ativo' => false, 'estado' => 'inativa']);
        }

        return $fatura;
    }

    public function downloadFatura(Fatura $fatura)
    {
        $invoiceService = new InvoiceService();
        return $invoiceService->download($fatura);
    }
}
