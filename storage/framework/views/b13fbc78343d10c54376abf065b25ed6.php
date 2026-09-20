<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .header { background-color: #1a5276; color: #fff; padding: 20px 30px; margin-bottom: 30px; }
        .header h1 { font-size: 20px; margin-bottom: 5px; }
        .header p { font-size: 11px; opacity: 0.8; }
        .fatura-info { display: flex; justify-content: space-between; margin-bottom: 25px; padding: 0 10px; }
        .fatura-info .bloco { width: 48%; }
        .fatura-info .bloco h3 { font-size: 11px; color: #1a5276; text-transform: uppercase; margin-bottom: 8px; border-bottom: 1px solid #ddd; padding-bottom: 4px; }
        .fatura-info .bloco p { margin-bottom: 3px; font-size: 11px; }
        .fatura-numero { text-align: right; }
        .fatura-numero h2 { font-size: 22px; color: #1a5276; margin-bottom: 5px; }
        .fatura-numero p { font-size: 11px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #1a5276; color: #fff; padding: 8px 12px; text-align: left; font-size: 11px; }
        td { padding: 8px 12px; border-bottom: 1px solid #eee; font-size: 11px; }
        .totais { width: 300px; margin-left: auto; }
        .totais tr td { padding: 6px 12px; }
        .totais tr:last-child td { border-top: 2px solid #1a5276; font-weight: bold; font-size: 13px; }
        .footer { margin-top: 40px; text-align: center; font-size: 10px; color: #999; border-top: 1px solid #eee; padding-top: 15px; }
        .notas { margin-top: 20px; padding: 15px; background: #f9f9f9; border-radius: 4px; }
        .notas h4 { font-size: 11px; color: #1a5276; margin-bottom: 5px; }
        .notas p { font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>QNB Imobiliária</h1>
        <p>Marketplace de Imóveis em Angola</p>
        <p>NIF: 5417892140 | Luanda, Angola</p>
    </div>

    <div class="fatura-info">
        <div class="bloco">
            <h3>Faturar A</h3>
            <p><strong><?php echo e($fatura->imobiliaria->nome ?? '—'); ?></strong></p>
            <p><?php echo e($fatura->imobiliaria->email ?? ''); ?></p>
            <p><?php echo e($fatura->imobiliaria->telefone ?? ''); ?></p>
            <p><?php echo e($fatura->imobiliaria->provincia ?? ''); ?>, <?php echo e($fatura->imobiliaria->municipio ?? ''); ?></p>
        </div>
        <div class="bloco fatura-numero">
            <h2>FATURA</h2>
            <p><strong>Nº:</strong> <?php echo e($fatura->numero); ?></p>
            <p><strong>Data:</strong> <?php echo e($fatura->emitida_em ? $fatura->emitida_em->format('d/m/Y') : now()->format('d/m/Y')); ?></p>
            <p><strong>Estado:</strong> <?php echo e($fatura->pagamento->estado === 'confirmado' ? 'Paga' : 'Pendente'); ?></p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Descrição</th>
                <th style="text-align:right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>Plano: <?php echo e($fatura->pagamento->subscricao->plano->nome ?? '—'); ?></strong><br>
                    <span style="font-size:10px;color:#666;">
                        Validade: <?php echo e($fatura->pagamento->subscricao->plano->dias_validade ?? 0); ?> dias |
                        Posts: <?php echo e($fatura->pagamento->subscricao->plano->posts_limite ?? 0); ?> imóveis
                    </span>
                </td>
                <td style="text-align:right;"><?php echo e(number_format($fatura->valor, 2, ',', '.')); ?> <?php echo e($fatura->moeda); ?></td>
            </tr>
        </tbody>
    </table>

    <table class="totais">
        <tr>
            <td>Subtotal:</td>
            <td style="text-align:right;"><?php echo e(number_format($fatura->valor, 2, ',', '.')); ?> <?php echo e($fatura->moeda); ?></td>
        </tr>
        <tr>
            <td>IVA (14%):</td>
            <td style="text-align:right;"><?php echo e(number_format($fatura->iva, 2, ',', '.')); ?> <?php echo e($fatura->moeda); ?></td>
        </tr>
        <tr>
            <td>Total:</td>
            <td style="text-align:right;"><?php echo e(number_format($fatura->total, 2, ',', '.')); ?> <?php echo e($fatura->moeda); ?></td>
        </tr>
    </table>

    <div class="notas">
        <h4>Dados Bancários</h4>
        <p><strong>Banco:</strong> BFA | <strong>IBAN:</strong> AO06 0040 0000 8857 2019 1019 5 | <strong>Titular:</strong> QNB Imobiliária, Lda</p>
    </div>

    <div class="footer">
        <p>QNB Imobiliária — Marketplace de Imóveis em Angola</p>
        <p>Este documento não substitui uma fatura oficial emitida pelo contribuinte.</p>
    </div>
</body>
</html>
<?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\pdf\fatura.blade.php ENDPATH**/ ?>