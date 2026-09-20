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
            <h2 style="color: #1a5276; margin-top: 0;">Nova Mensagem Recebida</h2>
            <p>Recebeu uma nova mensagem através do formulário de contacto do imóvel.</p>

            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">De</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $mensagem->nome }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Contacto</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $mensagem->contacto }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Imóvel</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $mensagem->imovel->titulo ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Origem</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ ucfirst($mensagem->origem) }}</td>
                </tr>
            </table>

            <div style="background-color: #f9f9f9; border-left: 4px solid #1a5276; padding: 15px; margin: 20px 0;">
                <strong style="color: #555;">Mensagem:</strong>
                <p style="margin: 10px 0 0 0; color: #333;">{{ $mensagem->texto }}</p>
            </div>

            <p>Acesse o painel para responder a esta mensagem.</p>
        </div>
        <div style="background-color: #f4f4f4; padding: 15px; text-align: center; font-size: 12px; color: #999;">
            &copy; {{ date('Y') }} QNB Imobiliária. Todos os direitos reservados.
        </div>
    </div>
</body>
</html>
