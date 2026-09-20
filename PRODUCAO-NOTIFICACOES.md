# Configuracao de Notificacoes Automaticas em Producao

## Visao Geral

O sistema QNB-Imobiliaria envia notificacoes automaticas por email para:
- Admin: Novo pagamento recebido, nova imobiliaria registada, imovel submetido
- Cliente (Imobiliaria): Pagamento confirmado/rejeitado, plano a expirar, plano expirado

---

## 1. Configuracao de Email (.env)

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=sua-senha-de-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@qnb-imobiliaria.co.ao
MAIL_FROM_NAME=QNB Imobiliaria

# Email para notificacoes do admin
MAIL_ADMIN_NOTIFICATION_EMAIL=admin@qnb-imobiliaria.co.ao
```

### Gmail - Senha de App

1. Acesse https://myaccount.google.com/security
2. Ative a verificacao em 2 etapas
3. Gere uma Senha de App em https://myaccount.google.com/apppasswords
4. Use a senha gerada no MAIL_PASSWORD

### SMTP Alternativos

| Provider | HOST | PORT | ENCRYPTION |
|----------|------|------|------------|
| Gmail | smtp.gmail.com | 587 | tls |
| Outlook | smtp.office365.com | 587 | tls |
| Amazon SES | email-smtp.us-east-1.amazonaws.com | 587 | tls |
| Mailgun | smtp.mailgun.org | 587 | tls |

---

## 2. Fila de Jobs (Queue)

As notificacoes usam Jobs em fila. Em producao, configure um worker:

### Opcao A: Database Driver (recomendado para VPS)

No .env:
```
QUEUE_CONNECTION=database
```

Criar tabela de jobs (ja existe migration):
```
php artisan queue:table
php artisan migrate
```

Iniciar o worker:
```
php artisan queue:work --sleep=3 --tries=3
```

### Opcao B: Redis (recomendado para alto volume)

No .env:
```
QUEUE_CONNECTION=redis
```

Instalar Redis:
```
composer require predis/predis
```

Iniciar o worker:
```
php artisan queue:work redis --sleep=3 --tries=3
```

---

## 3. Supervisor (manter worker ativo)

No servidor, instale o Supervisor:
```
sudo apt-get install supervisor
```

Criar ficheiro /etc/supervisor/conf.d/qnb-worker.conf:
```
[program:qnb-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/qnb-imobiliaria/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/log/qnb-worker.log
stopwaitsecs=3600
```

Ativar:
```
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start qnb-worker:*
```

---

## 4. Cron Job - Verificacao de Planos

O comando `planos:verificar` verifica planos expirados e envia emails.

Adicionar ao cron do servidor:
```
crontab -e
```

Adicionar esta linha:
```
* * * * * cd /var/www/qnb-imobiliaria && php artisan schedule:run >> /dev/null 2>&1
```

Registar o schedule em routes/console.php:
```php
use Illuminate\Support\Facades\Schedule;

Schedule::command('planos:verificar')->daily();
```

---

## 5. Tabelas Necessarias

Garantir que as migrations foram executadas:
```
php artisan migrate
```

Tabelas criticas:
- pagamentos (com motivo_rejeicao)
- faturas
- imobiliaria_plano (com notificado_a_expirar, notificado_expirado)
- pedidos_ativacao (com enum atualizado)

---

## 6. Storage - Links Simbolicos

Para os uploads de comprovativos e fotos funcionarem:
```
php artisan storage:link
```

---

## 7. Testes de Email

Para testar emails em producao sem enviar de verdade:

No .env:
```
MAIL_MAILER=log
```

Os emails serao gravados em storage/logs/laravel.log

---

## 8. Lista de Verificacao Pre-Producao

- [ ] Configurar MAIL_MAILER, MAIL_HOST, MAIL_USERNAME, MAIL_PASSWORD
- [ ] Configurar MAIL_ADMIN_NOTIFICATION_EMAIL
- [ ] Configurar QUEUE_CONNECTION=database (ou redis)
- [ ] Executar php artisan queue:table && php artisan migrate
- [ ] Configurar Supervisor para queue:work
- [ ] Configurar cron job para schedule:run
- [ ] Executar php artisan storage:link
- [ ] Testar envio de email com MAIL_MAILER=log
- [ ] Verificar que todos os jobs estao na fila
- [ ] Monitorar logs em storage/logs/laravel.log

---

## 9. Comandos Uteis

```
# Verificar planos expirados manualmente
php artisan planos:verificar

# Ver status da fila
php artisan queue:work --once

# Limpar jobs falhados
php artisan queue:flush

# Ver jobs pendentes
php artisan tinker
>>> App\Models\PendingJob::count()

# Testar envio de email
php artisan tinker
>>> App\Models\Imobiliaria::first()->notify(new App\Notifications\PlanoExpiradoNotification())
```

---

## 10. Notificacoes Disponiveis

| Notificacao | Trigger | Destinatario |
|-------------|---------|-------------|
| PagamentoRecebido | Imobiliaria submete pagamento | Admin |
| PagamentoConfirmado | Admin confirma pagamento | Imobiliaria |
| PagamentoRejeitado | Admin rejeita pagamento | Imobiliaria |
| PlanoAExpirar | 7 dias antes da expiracao | Imobiliaria |
| PlanoExpirado | Na data de expiracao | Imobiliaria |
| NovaImobiliariaRegistada | Nova imobiliaria se regista | Admin |
| ImovelSubmetido | Imobiliaria cria imovel | Admin |
| AssinaturaLiberada | Admin libera plano | Imobiliaria |
