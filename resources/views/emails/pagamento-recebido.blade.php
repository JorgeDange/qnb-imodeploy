<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Pagamento Recebido — QNB Imobiliária</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden;">
        <div style="background-color: #1a5276; color: #ffffff; padding: 20px; text-align: center;">
            <h1 style="margin: 0; font-size: 22px;">QNB Imobiliária</h1>
        </div>
        <div style="padding: 30px;">
            <h2 style="color: #1a5276; margin-top: 0;">Novo Pagamento Recebido</h2>
            <p>A imobiliária <strong>{{ $pagamento->imobiliaria->nome }}</strong> submeteu um novo pagamento para validação.</p>

            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Imobiliária</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $pagamento->imobiliaria->nome }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Plano</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $pagamento->subscricao->plano->nome ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Valor</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ number_format($pagamento->valor, 2, ',', '.') }} {{ $pagamento->moeda }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Método</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ ucfirst($pagamento->metodo) }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Referência</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $pagamento->referencia ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Data</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $pagamento->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            </table>

            @if($pagamento->comprovativo)
            <p><strong>Comprovativo:</strong> Anexo disponível no painel administrativo.</p>
            @endif

            <p>Acesse o painel administrativo para validar ou rejeitar este pagamento.</p>
        </div>
        <div style="background-color: #f4f4f4; padding: 15px; text-align: center; font-size: 12px; color: #999;">
            &copy; {{ date('Y') }} QNB Imobiliária. Todos os direitos reservados.
        </div>
    </div>
</body>
</html>
