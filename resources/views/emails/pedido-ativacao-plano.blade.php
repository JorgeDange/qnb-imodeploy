<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden;">
        <div style="background-color: #1a5276; color: #ffffff; padding: 20px; text-align: center;">
            <h1 style="margin: 0; font-size: 22px;">QNB Imobiliária</h1>
        </div>
        <div style="padding: 30px;">
            <h2 style="color: #1a5276; margin-top: 0;">Pedido de Ativação de Plano</h2>
            <p>A imobiliária <strong>{{ $pedido->imobiliaria->nome }}</strong> solicitou a ativação de um plano.</p>

            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Imobiliária</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $pedido->imobiliaria->nome }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Plano Pretendido</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $pedido->plano_pretendido }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Mensagem</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $pedido->mensagem ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Estado</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ ucfirst($pedido->estado) }}</td>
                </tr>
            </table>

            <p>Acesse o painel administrativo para analisar este pedido.</p>
        </div>
        <div style="background-color: #f4f4f4; padding: 15px; text-align: center; font-size: 12px; color: #999;">
            &copy; {{ date('Y') }} QNB Imobiliária. Todos os direitos reservados.
        </div>
    </div>
</body>
</html>
