<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plano expirado — QNB Imobiliária</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden;">
        <div style="background-color: #1a5276; color: #ffffff; padding: 20px; text-align: center;">
            <h1 style="margin: 0; font-size: 22px;">QNB Imobiliária</h1>
        </div>
        <div style="padding: 30px;">
            <h2 style="color: #e74c3c; margin-top: 0;">Plano Expirado</h2>
            <p>O seu plano <strong><?php echo e($assinatura->plano->nome); ?></strong> expirou em <strong><?php echo e($assinatura->data_expiracao->format('d/m/Y')); ?></strong>.</p>

            <div style="background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 6px; padding: 15px; margin: 20px 0;">
                <p style="margin: 0; color: #721c24;"><strong>Os seus anúncios foram desativados.</strong></p>
                <ul style="margin: 5px 0 0 0; color: #721c24;">
                    <li>Os seus imóveis já não aparecem no site</li>
                    <li>Não é possível criar novos anúncios</li>
                </ul>
            </div>

            <p>Ative um novo plano para voltar a publicar imóveis!</p>

            <div style="text-align: center; margin: 25px 0;">
                <a href="<?php echo e(route('painel.ativar-plano')); ?>" style="display:inline-block;background:#e74c3c;color:#fff;padding:12px 30px;border-radius:6px;text-decoration:none;font-weight:bold;">Ativar Novo Plano</a>
            </div>
        </div>
        <div style="background-color: #f4f4f4; padding: 15px; text-align: center; font-size: 12px; color: #999;">
            &copy; <?php echo e(date('Y')); ?> QNB Imobiliária. Todos os direitos reservados.
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\emails\plano-expirado.blade.php ENDPATH**/ ?>