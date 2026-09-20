<!DOCTYPE html>
<html lang="pt">
<head><meta charset="UTF-8"><title>Confirmar email</title></head>
<body style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h1 style="color: #1a3a5c;">Confirma o teu email</h1>
    <p>Olá {{ $cliente->nome }},</p>
    <p>Clica no botão abaixo para confirmar o teu email:</p>
    <p style="text-align: center; margin: 30px 0;">
        <a href="{{ $url }}" style="background: #1a3a5c; color: #fff; padding: 12px 24px; text-decoration: none; border-radius: 6px;">
            Confirmar email
        </a>
    </p>
    <p>Este link expira em 24 horas.</p>
    <p style="color: #888; font-size: 12px;">Se não criaste esta conta, ignora este email.</p>
</body>
</html>
