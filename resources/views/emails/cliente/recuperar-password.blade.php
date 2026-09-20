<!DOCTYPE html>
<html lang="pt">
<head><meta charset="UTF-8"><title>Recuperar password</title></head>
<body style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h1 style="color: #1a3a5c;">Recuperar password</h1>
    <p>Olá {{ $cliente->nome }},</p>
    <p>Recebemos um pedido para redefinir a tua password.</p>
    <p style="text-align: center; margin: 30px 0;">
        <a href="{{ $url }}" style="background: #1a3a5c; color: #fff; padding: 12px 24px; text-decoration: none; border-radius: 6px;">
            Redefinir password
        </a>
    </p>
    <p>Este link expira em 1 hora.</p>
    <p style="color: #888; font-size: 12px;">Se não pediste isto, ignora este email.</p>
</body>
</html>
