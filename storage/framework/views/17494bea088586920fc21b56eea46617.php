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
            <h2 style="color: #1a5276; margin-top: 0;">Nova Imobiliária Registada</h2>
            <p>Uma nova imobiliária registou-se na plataforma e aguarda aprovação.</p>

            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Nome</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo e($imobiliaria->nome); ?></td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">NIF</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo e($imobiliaria->nif); ?></td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Email</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo e($imobiliaria->email); ?></td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Telefone</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo e($imobiliaria->telefone); ?></td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Província</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo e($imobiliaria->provincia); ?></td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Município</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo e($imobiliaria->municipio); ?></td>
                </tr>
            </table>

            <p>Acesse o painel administrativo para aprovar ou rejeitar este registo.</p>
        </div>
        <div style="background-color: #f4f4f4; padding: 15px; text-align: center; font-size: 12px; color: #999;">
            &copy; <?php echo e(date('Y')); ?> QNB Imobiliária. Todos os direitos reservados.
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\emails\nova-imobiliaria-registada.blade.php ENDPATH**/ ?>