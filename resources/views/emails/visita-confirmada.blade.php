<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visita Confirmada</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden;">
        <div style="background-color: #1a5276; color: #ffffff; padding: 20px; text-align: center;">
            <h1 style="margin: 0; font-size: 22px;">QNB Imobiliária</h1>
        </div>
        <div style="padding: 30px;">
            <h2 style="color: #27ae60; margin-top: 0;">Visita Confirmada!</h2>
            <p>A sua visita foi confirmada pela imobiliária.</p>

            <div style="background: #d4edda; border: 1px solid #27ae60; border-radius: 6px; padding: 15px; margin: 20px 0;">
                <p style="margin: 0;"><strong>Imóvel:</strong> {{ $visita->imovel->titulo ?? '—' }}</p>
                <p style="margin: 5px 0 0 0;"><strong>Data:</strong> {{ $visita->data_visita->format('d/m/Y') }}</p>
                <p style="margin: 5px 0 0 0;"><strong>Hora:</strong> {{ $visita->data_visita->format('H:i') }}</p>
            </div>

            <p>Por favor, chegue a tempo. Em caso de alteração, entre em contacto com a imobiliária.</p>

            <div style="text-align: center; margin: 25px 0;">
                <a href="{{ route('home') }}" style="display:inline-block;background:#1a5276;color:#fff;padding:12px 30px;border-radius:6px;text-decoration:none;font-weight:bold;">Ver Imóvel</a>
            </div>
        </div>
        <div style="background-color: #f4f4f4; padding: 15px; text-align: center; font-size: 12px; color: #999;">
            &copy; {{ date('Y') }} QNB Imobiliária. Todos os direitos reservados.
        </div>
    </div>
</body>
</html>
