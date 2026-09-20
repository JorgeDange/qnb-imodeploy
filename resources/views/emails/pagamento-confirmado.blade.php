<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento Confirmado — QNB Imobiliária</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden;">
        <div style="background-color: #1a5276; color: #ffffff; padding: 20px; text-align: center;">
            <h1 style="margin: 0; font-size: 22px;">QNB Imobiliária</h1>
        </div>
        <div style="padding: 30px;">
            <h2 style="color: #10b981; margin-top: 0;">Pagamento Confirmado!</h2>
            <p>O seu pagamento foi <strong>confirmado</strong> com sucesso. O seu plano já está ativo!</p>

            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Plano</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $pagamento->subscricao->plano->nome ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Valor</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ number_format($pagamento->valor, 2, ',', '.') }} {{ $pagamento->moeda }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Validade</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $pagamento->subscricao->data_expiracao ? $pagamento->subscricao->data_expiracao->format('d/m/Y') : '—' }}</td>
                </tr>
                @if($pagamento->fatura)
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Fatura</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $pagamento->fatura->numero }}</td>
                </tr>
                @endif
            </table>

            <p>Pode agora publicar os seus imóveis no painel.</p>
        </div>
        <div style="background-color: #f4f4f4; padding: 15px; text-align: center; font-size: 12px; color: #999;">
            &copy; {{ date('Y') }} QNB Imobiliária. Todos os direitos reservados.
        </div>
    </div>
</body>
</html>
