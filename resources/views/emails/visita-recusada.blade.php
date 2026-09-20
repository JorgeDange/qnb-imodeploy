<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visita Indisponível</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden;">
        <div style="background-color: #1a5276; color: #ffffff; padding: 20px; text-align: center;">
            <h1 style="margin: 0; font-size: 22px;">QNB Imobiliária</h1>
        </div>
        <div style="padding: 30px;">
            <h2 style="color: #e74c3c; margin-top: 0;">Visita Indisponível</h2>
            <p>Infelizmente a visita não pôde ser agendada para o dia pretendido.</p>

            <div style="background: #f8d7da; border: 1px solid #e74c3c; border-radius: 6px; padding: 15px; margin: 20px 0;">
                <p style="margin: 0;"><strong>Imóvel:</strong> {{ $visita->imovel->titulo ?? '—' }}</p>
                <p style="margin: 5px 0 0 0;"><strong>Data pretendida:</strong> {{ $visita->data_visita->format('d/m/Y H:i') }}</p>
                @if($visita->observacoes)
                <p style="margin: 5px 0 0 0;"><strong>Motivo:</strong> {{ $visita->observacoes }}</p>
                @endif
            </div>

            <p>Pode escolher outro dia para a sua visita. Consulte os dias disponíveis no nosso site.</p>

            <div style="text-align: center; margin: 25px 0;">
                <a href="{{ route('home') }}" style="display:inline-block;background:#1a5276;color:#fff;padding:12px 30px;border-radius:6px;text-decoration:none;font-weight:bold;">Reagendar Visita</a>
            </div>
        </div>
        <div style="background-color: #f4f4f4; padding: 15px; text-align: center; font-size: 12px; color: #999;">
            &copy; {{ date('Y') }} QNB Imobiliária. Todos os direitos reservados.
        </div>
    </div>
</body>
</html>
