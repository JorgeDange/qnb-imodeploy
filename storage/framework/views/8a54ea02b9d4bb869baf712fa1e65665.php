<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento Rejeitado — QNB Imobiliária</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden;">
        <div style="background-color: #1a5276; color: #ffffff; padding: 20px; text-align: center;">
            <h1 style="margin: 0; font-size: 22px;">QNB Imobiliária</h1>
        </div>
        <div style="padding: 30px;">
            <h2 style="color: #e74c3c; margin-top: 0;">Pagamento Rejeitado</h2>
            <p>O seu pagamento foi <strong>rejeitado</strong> pela nossa equipa.</p>

            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Plano</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo e($pagamento->subscricao->plano->nome ?? '—'); ?></td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Valor</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo e(number_format($pagamento->valor, 2, ',', '.')); ?> <?php echo e($pagamento->moeda); ?></td>
                </tr>
                <?php if($pagamento->motivo_rejeicao): ?>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Motivo</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; color: #e74c3c;"><?php echo e($pagamento->motivo_rejeicao); ?></td>
                </tr>
                <?php endif; ?>
            </table>

            <p>Se deseja submeter um novo pagamento, aceda ao painel e tente novamente.</p>
        </div>
        <div style="background-color: #f4f4f4; padding: 15px; text-align: center; font-size: 12px; color: #999;">
            &copy; <?php echo e(date('Y')); ?> QNB Imobiliária. Todos os direitos reservados.
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\emails\pagamento-rejeitado.blade.php ENDPATH**/ ?>