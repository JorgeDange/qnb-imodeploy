<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O seu plano está a expirar — QNB Imobiliária</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden;">
        <div style="background-color: #1a5276; color: #ffffff; padding: 20px; text-align: center;">
            <h1 style="margin: 0; font-size: 22px;">QNB Imobiliária</h1>
        </div>
        <div style="padding: 30px;">
            <h2 style="color: #e67e22; margin-top: 0;">O seu plano está a expirar!</h2>
            <p>O seu plano <strong>{{ $assinatura->plano->nome }}</strong> expira em <strong>{{ $assinatura->data_expiracao->format('d/m/Y') }}</strong>.</p>
            <p>Faltam apenas <strong>{{ (int) $assinatura->data_expiracao->diffInDays(now()) }} dia(s)</strong> para a expiração.</p>

            <div style="background: #fff3cd; border: 1px solid #ffc107; border-radius: 6px; padding: 15px; margin: 20px 0;">
                <p style="margin: 0; color: #856404;"><strong>O que acontece se não renovar?</strong></p>
                <ul style="margin: 5px 0 0 0; color: #856404;">
                    <li>Os seus imóveis deixam de ser exibidos no site</li>
                    <li>Não poderá criar novos anúncios</li>
                    <li>Perderá os dados de estatísticas</li>
                </ul>
            </div>

            <p>Renove agora para manter os seus anúncios ativos!</p>

            <div style="text-align: center; margin: 25px 0;">
                <a href="{{ route('painel.ativar-plano') }}" style="display:inline-block;background:#1a5276;color:#fff;padding:12px 30px;border-radius:6px;text-decoration:none;font-weight:bold;">Renovar Plano</a>
            </div>
        </div>
        <div style="background-color: #f4f4f4; padding: 15px; text-align: center; font-size: 12px; color: #999;">
            &copy; {{ date('Y') }} QNB Imobiliária. Todos os direitos reservados.
        </div>
    </div>
</body>
</html>
