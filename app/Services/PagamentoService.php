<?php

namespace App\Services;

use App\Jobs\SendPagamentoRecebidoEmail;
use App\Models\Fatura;
use App\Models\FaturaLinha;
use App\Models\ImobiliariaPlano;
use App\Models\Pagamento;
use App\Models\Plano;
use App\Models\Imobiliaria;
use App\Services\InvoiceService;
use Illuminate\Http\UploadedFile;

class PagamentoService
{
    public function __construct(
        private EmpresaConfigService $configService,
    ) {}

    /**
     * Criar pagamento + fatura imediatamente.
     * Se comprovativo enviado → fatura vai para aguarda_aprovacao.
     * Se sem comprovativo → fatura fica pendente (imobiliária envia depois).
     */
    public function criarPagamento(
        Imobiliaria $imobiliaria,
        Plano $plano,
        string $metodo,
        ?string $referencia,
        ?UploadedFile $comprovativo,
    ): ImobiliariaPlano {
        // 1. Criar subscricao pendente
        $subscricao = ImobiliariaPlano::create([
            'imobiliaria_id' => $imobiliaria->id,
            'plano_id' => $plano->id,
            'posts_usados' => 0,
            'data_inicio' => null,
            'data_expiracao' => null,
            'ativo' => false,
            'estado' => 'pendente',
        ]);

        // 2. Criar registo de pagamento
        $caminhoComprovativo = null;
        if ($comprovativo) {
            $caminhoComprovativo = $comprovativo->store('pagamentos/comprovativos', 'public');
        }

        $pagamento = Pagamento::create([
            'subscricao_id' => $subscricao->id,
            'imobiliaria_id' => $imobiliaria->id,
            'valor' => $plano->preco,
            'moeda' => $plano->moeda,
            'metodo' => $metodo,
            'referencia' => $referencia,
            'comprovativo' => $caminhoComprovativo,
            'estado' => $comprovativo ? 'confirmado' : 'pendente',
        ]);

        // 3. Criar fatura imediatamente
        $fatura = $this->criarFatura($pagamento, $plano, $comprovativo ? $caminhoComprovativo : null);

        // 4. Notificar admin
        SendPagamentoRecebidoEmail::dispatch($pagamento);

        return $subscricao;
    }

    /**
     * Criar fatura com dados fiscais completos.
     */
    private function criarFatura(
        Pagamento $pagamento,
        Plano $plano,
        ?string $comprovativoPath,
    ): Fatura {
        $configFatura = $this->configService->configFatura();
        $snapshot = $this->configService->snapshot();

        $valorServico = (float) $pagamento->valor;
        $percentagemIva = $configFatura['iva_percentagem'];
        $percentagemRetencao = $configFatura['retencao_percentagem'];

        $iva = round($valorServico * $percentagemIva / 100, 2);
        $retencao = round($valorServico * $percentagemRetencao / 100, 2);
        $total = $valorServico + $iva - $retencao;

        $descricaoServico = "Assinatura {$plano->nome} — {$plano->dias_validade} dias";

        // Estado: se tem comprovativo → aguarda_aprovacao, senão → pendente
        $estado = $comprovativoPath ? 'aguarda_aprovacao' : 'pendente';

        $fatura = Fatura::create([
            'numero' => Fatura::proximoNumero(),
            'pagamento_id' => $pagamento->id,
            'imobiliaria_id' => $pagamento->imobiliaria_id,
            'valor' => $valorServico,
            'moeda' => $pagamento->moeda,
            'iva' => $iva,
            'subtotal' => $valorServico,
            'desconto' => 0,
            'retencao' => $retencao,
            'total' => $total,
            'nota' => str_replace('{dias}', (string) $configFatura['dias_vencimento'], $configFatura['termos']),
            'emitida_em' => now(),
            'estado' => $estado,
            // Comprovativo
            'comprovativo_path' => $comprovativoPath,
            'comprovativo_enviado_em' => $comprovativoPath ? now() : null,
            'comprovativo_enviado_por' => $comprovativoPath ? $pagamento->imobiliaria_id : null,
            // Snapshot empresa
            'empresa_nome'      => $snapshot['empresa_nome'],
            'empresa_nif'       => $snapshot['empresa_nif'],
            'empresa_endereco'  => $snapshot['empresa_endereco'],
            'empresa_telefone'  => $snapshot['empresa_telefone'],
            'empresa_email'     => $snapshot['empresa_email'],
            'banco_nome'        => $snapshot['banco_nome'],
            'banco_iban'        => $snapshot['banco_iban'],
            'banco_titular'     => $snapshot['banco_titular'],
        ]);

        // Criar linha da fatura
        FaturaLinha::create([
            'fatura_id' => $fatura->id,
            'descricao' => $descricaoServico,
            'quantidade' => 1,
            'valor_unitario' => $valorServico,
            'subtotal' => $valorServico,
        ]);

        // Gerar PDF
        $invoiceService = app(InvoiceService::class);
        $invoiceService->gerarPdf($fatura);

        return $fatura;
    }

    /**
     * Criar fatura direta (sem formulário de pagamento intermédio).
     * Usado quando imobiliária clica "Ativar Agora" num plano.
     */
    public function criarFaturaDireta(
        Imobiliaria $imobiliaria,
        Plano $plano,
    ): Fatura {
        // 1. Criar subscricao pendente
        $subscricao = ImobiliariaPlano::create([
            'imobiliaria_id' => $imobiliaria->id,
            'plano_id' => $plano->id,
            'posts_usados' => 0,
            'data_inicio' => null,
            'data_expiracao' => null,
            'ativo' => false,
            'estado' => 'pendente',
        ]);

        // 2. Criar registo de pagamento (sem comprovativo ainda)
        $pagamento = Pagamento::create([
            'subscricao_id' => $subscricao->id,
            'imobiliaria_id' => $imobiliaria->id,
            'valor' => $plano->preco,
            'moeda' => $plano->moeda,
            'metodo' => 'transferencia',
            'estado' => 'pendente',
        ]);

        // 3. Criar fatura (pendente — imobiliária envia comprovativo depois)
        $fatura = $this->criarFatura($pagamento, $plano, null);

        return $fatura;
    }

    public function downloadFatura(Fatura $fatura)
    {
        $invoiceService = app(InvoiceService::class);
        return $invoiceService->download($fatura);
    }
}
