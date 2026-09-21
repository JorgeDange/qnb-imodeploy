# 🚀 DEPLOY — QNB-Imobiliária (Laravel 12)

> Guia completo para colocar o backend Laravel em produção.
> Criado em 2026-09-21 após verificação de preparação para hospedagem.

---

## 1. Verificação de Prontidão (resultado da auditoria)

| Item | Estado | Nota |
|------|--------|------|
| Suite de testes | ✅ | 111 testes passam (9 skipped, 1 risky) |
| `config:cache` / `route:cache` / `view:cache` | ✅ | Compilam sem erros |
| APP_KEY | ✅ | Presente (gerar nova em produção!) |
| `public/.htaccess` | ✅ | Existe (Apache) |
| Health check | ✅ | `GET /health` retorna JSON com db/cache/storage |
| Assets (JS/CSS) | ✅ | 100% locais, sem CDN externo |
| Queue/Sessions/Cache | ✅ | Driver `database` (funciona em hospedagem partilhada) |
| Vite build | ✅ | Views não usam `@vite` — **não é preciso `npm run build`** |
| `.env.example` | ⚠️ | Estava genérico (SQLite) — atualizado para MySQL |
| Scheduler (cron) | ⚠️ | Comandos comentados em `routes/console.php` |
| Módulos 9-10 (.env completo, segurança) | ⚠️ | Pendentes conforme memoria.md — este documento cobre o essencial |
| Credenciais demo (demo@ / admin@) | 🔴 | **Nunca semear dados demo em produção** |

**Conclusão: o sistema ESTÁ PRONTO para hospedagem**, desde que as configurações de produção abaixo sejam aplicadas.

---

## 2. Requisitos do Servidor

| Requisito | Versão mínima |
|-----------|---------------|
| PHP | **8.2+** (8.3 recomendado) |
| MySQL / MariaDB | 8.0+ / 10.6+ |
| Composer | 2.x |
| Extensões PHP | `pdo_mysql`, `mbstring`, `openssl`, `ctype`, `json`, `gd` (processamento de fotos), `fileinfo`, `zip` (DOMPDF), `intl` |
| Allow_url_fopen | On (para baixar assets se necessário) |

> **Hospedagem partilhada (cPanel):** confirmar que o PHP selecionado é 8.2+ no "MultiPHP Manager" e que as extensões estão ativadas em "Select PHP Version".

---

## 3. Configuração do `.env` de Produção

Copiar `.env.example` para `.env` no servidor e ajustar:

```bash
# ─── APLICAÇÃO ─────────────────────────────────────────────
APP_NAME="QNB Imobiliária"
APP_ENV=production              # NUNCA "local"
APP_KEY=                        # gerar: php artisan key:generate
APP_DEBUG=false                 # NUNCA true em produção (expõe stack traces)
APP_URL=https://www.qnbangola.com   # domínio real, com https

APP_LOCALE=pt                   # projeto é PT-PT (estava "en")
APP_FALLBACK_LOCALE=pt
APP_FAKER_LOCALE=pt_PT

# ─── BASE DE DADOS (MySQL) ─────────────────────────────────
DB_CONNECTION=mysql
DB_HOST=127.0.0.1               # ou host fornecido pelo painel (ex: localhost)
DB_PORT=3306
DB_DATABASE=qnb_imobiliaria
DB_USERNAME=qnb_user            # utilizador dedicado, NÃO root
DB_PASSWORD=senha_forte_aqui    # gerada, com 20+ caracteres

# ─── SESSÕES / CACHE / FILAS ───────────────────────────────
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=true            # cookies de sessão encriptados
SESSION_SECURE_COOKIE=true      # só envia cookie por HTTPS
QUEUE_CONNECTION=database
CACHE_STORE=database

# ─── EMAIL (SMTP real — obrigatório para verificações) ─────
MAIL_MAILER=smtp
MAIL_HOST=mail.qnbangola.com    # ou smtp do provedor (ex: smtp.hostinger.com)
MAIL_PORT=465                   # 465=SSL, 587=TLS
MAIL_USERNAME=comercial@qnbangola.com
MAIL_PASSWORD=senha_do_email
MAIL_ENCRYPTION=ssl             # "ssl" porta 465 / "tls" porta 587
MAIL_FROM_ADDRESS="comercial@qnbangola.com"
MAIL_FROM_NAME="${APP_NAME}"

# ─── FICHEIROS / OUTROS ────────────────────────────────────
FILESYSTEM_DISK=public
FRONTEND_URL=https://www.qnbangola.com
LOG_CHANNEL=daily               # roda logs por dia (evita ficheiro gigante)
LOG_LEVEL=error                 # menos ruído em produção
BCRYPT_ROUNDS=12
```

### ⚠️ Pontos críticos do `.env`

1. **APP_DEBUG=false** — com `true`, qualquer visitante vê erros, caminhos e credenciais.
2. **APP_KEY nova** — correr `php artisan key:generate` no servidor. Não reutilizar a key de desenvolvimento (as sessões/cookies encriptados ficam comprometidos se a key de dev vazar).
3. **MAIL_MAILER=log não serve** — em produção os emails (verificação de cliente, aprovações, faturas) precisam de SMTP real. Criar a conta de email `comercial@qnbangola.com` no painel da hospedagem.
4. **Permissões**: pastas precisam 755, ficheiros 644. **Nunca 777.** O `storage/` e `bootstrap/cache/` precisam ser escritos pelo utilizador do PHP.

---

## 4. Opção A — Hospedagem Partilhada (cPanel)

> Estrutura recomendada: código Laravel FORA de `public_html`, apenas `public/` aponta para dentro.

### Passo 1 — Criar base de dados
1. cPanel → **MySQL Databases** → criar base `user_qnb_imobiliaria`
2. Criar utilizador `user_qnb` com password forte
3. Associar utilizador à base com **ALL PRIVILEGES**

### Passo 2 — Enviar o código
```bash
# No cPanel Terminal ou via SSH:
cd ~
# Enviar o projeto (via Git recomendado):
git clone https://github.com/SEU_USER/qnb.git qnb-app
cd qnb-app/qnb-imobiliaria
```
> Alternativa sem SSH: compactar o projeto (sem `vendor/` e sem `node_modules/`), subir o .zip pelo File Manager e extrair em `/home/USER/qnb-app/`.

### Passo 3 — Instalar dependências
```bash
composer install --no-dev --optimize-autoloader
```
> Sem SSH: instalar localmente com `composer install --no-dev` e subir a pasta `vendor/` junto com o resto.

### Passo 4 — Configurar `.env`
Criar o `.env` conforme a secção 3, depois:
```bash
php artisan key:generate --force
php artisan migrate --force
# ⚠️ NÃO correr db:seed em produção!
# Se precisar dos planos iniciais:
php artisan db:seed --force --class=PlanosSeeder
php artisan db:seed --force --class=AmenidadesSeeder
```

### Passo 5 — Link de storage e caches
```bash
php artisan storage:link          # cria public/storage → storage/app/public
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Passo 6 — Apontar o domínio para `public/`
**Opção 1 (ideal):** cPanel → Domains → alterar **Document Root** do domínio para:
```
/home/USER/qnb-app/qnb-imobiliaria/public
```

**Opção 2 (se não puder mudar document root):** mover o conteúdo de `public/` para `public_html/` e editar o `index.php`:
```php
require __DIR__.'/../qnb-app/qnb-imobiliaria/vendor/autoload.php';
$app = require_once __DIR__.'/../qnb-app/qnb-imobiliaria/bootstrap/app.php';
```
> E editar também o `.htaccess` de `public_html/` se necessário.

### Passo 7 — Worker de filas (obrigatório)
Os emails são enviados via fila (`QUEUE_CONNECTION=database`). Sem worker, **ninguém recebe email**.

**cPanel → Cron Jobs**, adicionar (a cada minuto):
```bash
* * * * * cd /home/USER/qnb-app/qnb-imobiliaria && php artisan queue:work --stop-when-empty --tries=3 --max-time=55 >> /dev/null 2>&1
```

### Passo 8 — Scheduler (cron do Laravel)
```bash
* * * * * cd /home/USER/qnb-app/qnb-imobiliaria && php artisan schedule:run >> /dev/null 2>&1
```
> Quando os comandos `subscricoes:expirar`, `logs:purgar` etc. forem descomentados no `routes/console.php`, este cron passa a processá-los automaticamente.

---

## 5. Opção B — VPS (Ubuntu + Nginx)

```bash
# 1. Pacotes
sudo apt update && sudo apt install -y nginx mysql-server php8.3-fpm php8.3-mysql php8.3-mbstring \
  php8.3-xml php8.3-gd php8.3-curl php8.3-zip php8.3-intl unzip

# 2. Código
cd /var/www
sudo git clone https://github.com/SEU_USER/qnb.git qnb && cd qnb/qnb-imobiliaria
sudo composer install --no-dev --optimize-autoloader

# 3. Permissões
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# 4. MySQL seguro
sudo mysql_secure_installation
sudo mysql -e "CREATE DATABASE qnb_imobiliaria CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
sudo mysql -e "CREATE USER 'qnb'@'localhost' IDENTIFIED BY 'SENHA_FORTE';"
sudo mysql -e "GRANT ALL ON qnb_imobiliaria.* TO 'qnb'@'localhost'; FLUSH PRIVILEGES;"

# 5. .env conforme secção 3, depois:
php artisan key:generate --force
php artisan migrate --force
php artisan storage:link
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

### Config Nginx (`/etc/nginx/sites-available/qnb`)
```nginx
server {
    listen 80;
    server_name www.qnbangola.com qnbangola.com;
    root /var/www/qnb/qnb-imobiliaria/public;   # ← SEMPRE a pasta public/

    index index.php;
    client_max_body_size 25M;                   # uploads de fotos até ~20MB

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
    }

    location ~ /\.(?!well-known) { deny all; }
}
```
```bash
sudo ln -s /etc/nginx/sites-available/qnb /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
sudo certbot --nginx -d qnbangola.com -d www.qnbangola.com   # HTTPS grátis
```

### Supervisor para o worker de filas (`/etc/supervisor/conf.d/qnb-worker.conf`)
```ini
[program:qnb-worker]
command=php /var/www/qnb/qnb-imobiliaria/artisan queue:work --tries=3 --max-time=3600
autostart=true
autorestart=true
user=www-data
numprocs=1
stdout_logfile=/var/www/qnb/qnb-imobiliaria/storage/logs/worker.log
```
```bash
sudo supervisorctl reread && sudo supervisorctl update && sudo supervisorctl start qnb-worker
```

### Cron do scheduler
```bash
* * * * * cd /var/www/qnb/qnb-imobiliaria && php artisan schedule:run >> /dev/null 2>&1
```

---

## 6. Checklist Pós-Deploy (executar por ordem)

```bash
# 1. Atualizar código
git pull origin main

# 2. Dependências (se composer.lock mudou)
composer install --no-dev --optimize-autoloader

# 3. Migrations (nunca correr em produção sem --force)
php artisan migrate --force

# 4. Limpar e regenerar caches
php artisan config:clear && php artisan route:clear && php artisan view:clear
php artisan config:cache && php artisan route:cache && php artisan view:cache

# 5. Reiniciar worker (se existir)
php artisan queue:restart
```

### Verificações manuais
- [ ] `https://DOMINIO/health` → `{"status":"healthy", ...}`
- [ ] Home carrega com imóveis (sem dados demo se BD limpa — criar 1º admin: ver secção 7)
- [ ] Login do painel `/painel/login` funciona
- [ ] Login do CRM `/admin/login` funciona
- [ ] Upload de fotos num imóvel de teste → imagem visível em `public/storage/imoveis/...`
- [ ] Fatura PDF (`/faturas/{id}/download`) gera sem erro
- [ ] Email de registo de cliente chega à caixa de entrada (verificar **não** em spam; configurar SPF/DKIM no DNS)
- [ ] `APP_DEBUG=false` → um 404 deve mostrar página de erro limpa, não stack trace

---

## 7. Primeiro Administrador em Produção

Como não se deve correr seeders de demo, criar o admin via tinker:
```bash
php artisan tinker
```
```php
\App\Models\Admin::create([
    'nome'  => 'Jorge Dange',
    'email' => 'SEU_EMAIL@qnbangola.com',
    'password' => bcrypt('PALAVRA-PASSE_FORTE'),
    'role'  => 'super_admin',
    'ativo' => true,
]);
```
> **Ajustar os nomes dos campos ao migration `admins` real** (verificar `nome` vs `name`). Eliminar este admin de teste apenas se já existir outro.

Também criar os planos base se a BD estiver vazia:
```bash
php artisan db:seed --force --class=PlanosSeeder
php artisan db:seed --force --class=AmenidadesSeeder
```

---

## 8. Segurança — Obrigatório Antes de Divulgar

| # | Item | Como |
|---|------|------|
| 1 | HTTPS obrigatório | Let's Encrypt (certbot) ou AutoSSL do cPanel; forçar redirect 80→443 |
| 2 | `.env` inacessível | Está fora de `public/` (Opção A passo 6 garante isso) |
| 3 | `APP_DEBUG=false` | Secção 3 |
| 4 | Sem dados demo | Não correr `db:seed` completo; passwords demo (`demo1234`, `admin1234`) não podem existir em produção |
| 5 | HTTPS nos cookies | `SESSION_SECURE_COOKIE=true` |
| 6 | Backups automáticos | cPanel: backup diário da BD + `storage/app/public`; ou mysqldump cron no VPS |
| 7 | Rate limiting | Já implementado (throttle em login/admin-login/denúncias) ✅ |
| 8 | Headers de segurança | Adicionar ao `.htaccess`/nginx (ver abaixo) |

**Headers no `.htaccess` (Apache):**
```apache
<IfModule mod_headers.c>
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set X-Content-Type-Options "nosniff"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
    Header always set X-XSS-Protection "1; mode=block"
</IfModule>
```

**Headers no Nginx:**
```nginx
add_header X-Frame-Options "SAMEORIGIN" always;
add_header X-Content-Type-Options "nosniff" always;
add_header Referrer-Policy "strict-origin-when-cross-origin" always;
```

---

## 9. Rollback / Emergência

```bash
# Página de manutenção durante atualizações:
php artisan down --retry=60
# ... atualizar ...
php artisan up

# Voltar caches atrás (modo debug temporário — só em emergência):
php artisan config:clear

# Ver erros recentes:
tail -100 storage/logs/laravel-$(date +%F).log   # ou laravel.log se LOG_CHANNEL=single

# Repor worker após código novo:
php artisan queue:restart
```

---

## 10. Diferenças Dev → Produção (resumo rápido)

| Variável | Desenvolvimento (atual) | Produção |
|----------|------------------------|----------|
| `APP_ENV` | `local` | `production` |
| `APP_DEBUG` | `true` | `false` |
| `APP_URL` | `http://127.0.0.1:8899` | `https://www.qnbangola.com` |
| `APP_LOCALE` | `en` | `pt` |
| `MAIL_MAILER` | `log` | `smtp` com credenciais reais |
| `LOG_CHANNEL` | `stack`/`single` | `daily` |
| `LOG_LEVEL` | `debug` | `error` |
| `DB_USERNAME` | `root` | utilizador dedicado com password forte |
| `FRONTEND_URL` | `http://localhost:8080` | `https://www.qnbangola.com` |

---

*Documento gerado após verificação de 2026-09-21. Atualizar sempre que a stack ou o fluxo de deploy mudar.*
