# 🚀 DEPLOY — QNB-Imobiliária (Laravel 12)

> Guia completo para colocar em produção as **DUAS aplicações** do projeto:
> - **qnb-imobiliaria** — site público + painel do anunciante + área do cliente → `www.qnbangola.com`
> - **qnb-admin** — CRM interno (admin/moderador) → domínio separado (ver §10), ex. `admin.qnbangola.com`
>
> **Motivação da separação: segurança por isolamento de domínio** — os administradores não acedem pelo mesmo domínio do site. Ambas partilham a MESMA BD MySQL (ver `planMove.md` §1.1).
>
> Criado em 2026-09-21 · Atualizado com arquitetura de 2 apps após F0-F4 do planMove.md.

---

## 0. Visão geral das 2 apps (LER PRIMEIRO)

| | qnb-imobiliaria | qnb-admin |
|---|-----------------|-----------|
| Conteúdo | Site público + painel anunciante + cliente | CRM admin/moderador |
| Domínio | `www.qnbangola.com` | `admin.qnbangola.com` (ou domínio neutro) |
| BD MySQL | `qnb_imobiliaria` | **a mesma** `qnb_imobiliaria` |
| Migrations | **SÓ esta app corre migrations** | Nunca corre migrations |
| Fila (queue) | `publico` | `admin` |
| Guard de auth | `imobiliaria` + `cliente` | `admin` |
| Observers | Sim (disparam emails públicos) | **Nenhum** (evita duplicados) |
| APP_KEY | Própria | Própria (diferente) |
| Health check | `/health` | `/health` |
| Testes | 77 passed | 34 passed |

**URLs cruzados (config/app.php):**
- na imobiliaria: `ADMIN_URL` → domínio do CRM (usado em notificações in-app de faturas)
- no qnb-admin: `FRONTEND_URL` → domínio do site (links "Ver site público")

**Regra de ouro dos workers:** cada app processa APENAS a sua fila (`--queue=publico` / `--queue=admin`). Com a BD partilhada, a tabela `jobs` é única — sem filas nomeadas, o worker errado apanhava jobs de classes inexistentes na outra app (validado na F4).

---

## 1. Verificação de Prontidão (resultado da auditoria)

| Item | Estado | Nota |
|------|--------|------|
| Suite de testes | ✅ | qnb-imobiliaria: 77 passed · qnb-admin: 34 passed |
| `config:cache` / `route:cache` / `view:cache` | ✅ | Compilam sem erros nas 2 apps |
| APP_KEY | ✅ | Presente (gerar NOVA em produção em cada app!) |
| `public/.htaccess` | ✅ | Existe nas 2 apps |
| Health check | ✅ | `GET /health` nas 2 apps |
| Assets (JS/CSS) | ✅ | 100% locais, sem CDN externo |
| Queue/Sessions/Cache | ✅ | Driver `database` + filas nomeadas por app |
| Vite build | ✅ | Views não usam `@vite` — **não é preciso `npm run build`** |
| `.env.example` | ✅ | MySQL + locale pt nas 2 apps |
| Scheduler (cron) | ⚠️ | Comandos comentados em `routes/console.php` (imobiliaria) |
| Credenciais demo (demo@ / admin@) | 🔴 | **Nunca semear dados demo em produção** |

**Conclusão: as DUAS apps estão prontas para hospedagem**, desde que as configurações abaixo sejam aplicadas.

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
FRONTEND_URL=https://www.qnbangola.com    # o próprio domínio
ADMIN_URL=https://admin.qnbangola.com     # ← domínio do CRM (qnb-admin)
DB_QUEUE=publico                          # ← fila desta app (NUNCA mudar)
LOG_CHANNEL=daily               # roda logs por dia (evita ficheiro gigante)
LOG_LEVEL=error                 # menos ruído em produção
BCRYPT_ROUNDS=12
```

### 3.1 `.env` de produção do **qnb-admin** (diferenças em relação a cima)

```bash
APP_NAME="QNB Admin (CRM)"
APP_URL=https://admin.qnbangola.com       # domínio do CRM
FRONTEND_URL=https://www.qnbangola.com    # domínio do site (links "Ver site")
# ADMIN_URL — não é usado no qnb-admin
DB_QUEUE=admin                            # ← fila desta app (NUNCA mudar)
# DB_* — MESMOS valores da imobiliaria (BD partilhada)
# MAIL_* — MESMO SMTP (emails de aprovações saem do CRM)
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
APP_DEBUG=false
```
> `APP_KEY` do qnb-admin tem de ser **diferente** da da imobiliaria (cada app gera a sua com `php artisan key:generate`).
> **O qnb-admin NUNCA corre `php artisan migrate`** — o schema é gerido exclusivamente pela imobiliaria.

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
**Esta app processa APENAS a fila `publico`** (a fila `admin` é do CRM).

**cPanel → Cron Jobs**, adicionar (a cada minuto):
```bash
* * * * * cd /home/USER/qnb-app/qnb-imobiliaria && php artisan queue:work --stop-when-empty --tries=3 --max-time=55 --queue=publico >> /dev/null 2>&1
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
command=php /var/www/qnb/qnb-imobiliaria/artisan queue:work --tries=3 --max-time=3600 --queue=publico
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

### Verificações manuais (qnb-imobiliaria)
- [ ] `https://DOMINIO/health` → `{"status":"healthy", ...}`
- [ ] Home carrega com imóveis (sem dados demo se BD limpa)
- [ ] Login do painel `/painel/login` funciona
- [ ] **NÃO existe `/admin/login` nesta app** (o CRM vive no outro domínio — deve dar 404)
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
| `APP_URL` | `http://127.0.0.1:8899` / `:8898` | `https://www.qnbangola.com` / `https://admin.qnbangola.com` |
| `APP_LOCALE` | `pt` | `pt` |
| `MAIL_MAILER` | `log` | `smtp` com credenciais reais |
| `LOG_CHANNEL` | `stack`/`single` | `daily` |
| `LOG_LEVEL` | `debug` | `error` |
| `DB_USERNAME` | `root` | utilizador dedicado com password forte |
| `FRONTEND_URL` | `http://127.0.0.1:8899` | `https://www.qnbangola.com` |
| `ADMIN_URL` | `http://127.0.0.1:8898` | `https://admin.qnbangola.com` |
| `DB_QUEUE` | `publico` / `admin` | **mantém** (`publico` na site app, `admin` no CRM) |

---

## 11. Deploy do qnb-admin (CRM) — segundo hosting

> Requisito de segurança (planMove.md §1.1 e §9): o CRM vive num domínio SEPARADO do site.
> A ordem recomendada é: **primeiro a imobiliaria (secções 4/5), depois o qnb-admin.**

### Passo 1 — Escolher o modelo de hosting

| Modelo | Vantagens | Desvantagens |
|--------|-----------|--------------|
| **A. Mesma conta de hosting, domínio adicional** `admin.qnbangola.com` | BD fica LOCAL para ambas (rápido, sem MySQL remoto); 1 só fatura | CRM "descobrível" por quem conhece o domínio |
| **B. Hosting totalmente separado** (ex.: outro fornecedor) | CRM invisível ao hosting do site; isolamento máximo | MySQL remoto (latência + configurar SSL/IP whitelist); uploads partilhados complicados (ver §12) |

> Recomendação prática: **Modelo A** para começar (simples e rápido), migrando para B mais tarde se a segurança exigir. Com o Modelo A, o endurecimento da secção 9 (IP whitelist/Basic Auth) torna-se ainda mais importante.

### Passo 2 — Instalar (cPanel)
```bash
cd ~
git clone https://github.com/SEU_USER/qnb.git qnb-admin-app
cd qnb-admin-app/qnb-admin
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate --force     # APP_KEY PRÓPRIA (≠ da imobiliaria)
# ⚠️ NUNCA correr php artisan migrate nesta app!
php artisan storage:link
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

### Passo 3 — `.env` de produção (resumo)
Ver secção 3.1. Essencial: `DB_*` iguais aos da imobiliaria, `DB_QUEUE=admin`, `FRONTEND_URL` = domínio do site, `APP_DEBUG=false`, `SESSION_SECURE_COOKIE=true`.

### Passo 4 — Apontar o domínio
cPanel → Domains → criar domínio adicional/subdomínio `admin.qnbangola.com` com Document Root:
```
/home/USER/qnb-admin-app/qnb-admin/public
```

### Passo 5 — Worker da fila do CRM
cPanel → Cron Jobs (a cada minuto):
```bash
* * * * * cd /home/USER/qnb-admin-app/qnb-admin && php artisan queue:work --stop-when-empty --tries=3 --max-time=55 --queue=admin >> /dev/null 2>&1
```

### Passo 6 — Primeiro administrador do CRM
O admin não vem de seeders de demo. Criar via tinker:
```bash
php artisan tinker
```
```php
\App\Models\Admin::create([
    'nome' => 'Jorge Dange',
    'email' => 'jorge@qnbangola.com',
    'password' => bcrypt('PALAVRA-PASSE_FORTE'),
    'role' => 'super_admin',
    'ativo' => true,
]);
```

### Passo 7 — Endurecimento do domínio (OBRIGATÓRIO — planMove.md §9)
- [ ] `robots.txt` no `public/` do qnb-admin: `User-agent: *\nDisallow: /`
- [ ] Header `X-Robots-Tag: noindex, nofollow` (`.htaccess` ou Nginx)
- [ ] cPanel → Directory Privacy (Basic Auth) sobre a pasta do CRM, **OU** IP whitelist:
```apache
# public/.htaccess do qnb-admin (antes das regras do Laravel)
<RequireAny>
    Require ip XXX.XXX.XXX.XXX   # IP fixo da equipa QNB
    Require ip YYY.YYY.YYY.YYY
</RequireAny>
```
- [ ] HTTPS (AutoSSL/Let's Encrypt) + `SESSION_SECURE_COOKIE=true` + `SESSION_ENCRYPT=true`
- [ ] Headers de segurança (secção 8) aplicados também neste domínio
- [ ] `/health` protegido (Basic Auth acima já o protege)
- [ ] Verificar que NENHUM email/página pública do site revela o domínio do CRM
- [ ] Nenhum link do site aponta para o CRM (auditar: `grep -rn "ADMIN_URL\|admin_url" resources/views/` na imobiliaria — só pode aparecer em notificações in-app/emails PRIVADOS de admins)

### Passo 8 — Verificações finais (2 domínios)
- [ ] `https://admin.qnbangola.com/admin/login` carrega e o login funciona
- [ ] `https://www.qnbangola.com/admin/login` dá **404** (rotas admin não existem no site)
- [ ] Aprovar um imóvel no CRM → aparece no site
- [ ] Submeter comprovativo no painel do anunciante → aparece no CRM
- [ ] Emails chegam SEM duplicados (1 aprovação = 1 email)
- [ ] `https://admin.qnbangola.com/health` → healthy

---

## 12. Uploads partilhados entre as 2 apps (atenção!)

A BD é partilhada, mas o **disco NÃO é**: os paths dos uploads (`imoveis/foto1.jpg`, `faturas/FT-2026-0001.pdf`, comprovativos...) ficam em `storage/app/public` de CADA app.

| Modelo de hosting (§11) | Solução de uploads |
|------------------------|--------------------|
| **A. Mesma conta cPanel** | As 2 apps podem apontar para a MESMA pasta: no qnb-admin, recriar o link `public/storage` como symlink (Linux) para a pasta da imobiliaria: `ln -sfn /home/USER/qnb-app/qnb-imobiliaria/storage/app/public /home/USER/qnb-admin-app/qnb-admin/public/storage` |
| **B. Hostings separados** | Opções: (1) sincronização via rsync cron; (2) migrar `FILESYSTEM_DISK` para S3/Cloudflare R2/DigitalOcean Spaces (recomendado a medio prazo — editar `config/filesystems.php` nas 2 apps); (3) servir uploads por URL absoluto do hosting A |

> No dev local (Windows) já está resolvido: junction `qnb-admin/public/storage` → `qnb-imobiliaria/storage/app/public`.

---

*Documento gerado após verificação de 2026-09-21. Atualizado com arquitetura de 2 apps (F0-F4 do planMove.md). Atualizar sempre que a stack ou o fluxo de deploy mudar.*
