<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($subject); ?></title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden;">
        <div style="background-color: #1a5276; color: #ffffff; padding: 20px; text-align: center;">
            <h1 style="margin: 0; font-size: 22px;">QNB Imobiliária</h1>
        </div>
        <div style="padding: 30px;">
            <h2 style="color: #1a5276; margin-top: 0;">Imóvel Submetido para Aprovação</h2>
            <p>Um novo imóvel foi submetido pela imobiliária <strong><?php echo e($imovel->imobiliaria->nome); ?></strong> e aguarda revisão.</p>

            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Referência</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo e($imovel->referencia); ?></td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Título</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo e($imovel->titulo); ?></td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Tipo</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo e($imovel->tipo); ?></td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Finalidade</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo e($imovel->finalidade); ?></td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Preço</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo e(number_format($imovel->preco, 2, ',', '.')); ?> <?php echo e($imovel->moeda); ?></td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Localização</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo e($imovel->bairro); ?>, <?php echo e($imovel->municipio); ?>, <?php echo e($imovel->provincia); ?></td>
                </tr>
            </table>

            <p>Acesse o painel administrativo para aprovar ou rejeitar este imóvel.</p>
        </div>
        <div style="background-color: #f4f4f4; padding: 15px; text-align: center; font-size: 12px; color: #999;">
            &copy; <?php echo e(date('Y')); ?> QNB Imobiliária. Todos os direitos reservados.
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\emails\imovel-submetido.blade.php ENDPATH**/ ?>