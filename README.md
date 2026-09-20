# QNB-Imobiliária — Backend

Backend Laravel 12 da plataforma QNB-Imobiliária.

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve --port=8000
```

## Credenciais

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@qnbangola.com | admin1234 |
| Imobiliária | demo@qnbangola.com | demo1234 |
| Cliente | cliente@qnbangola.com | cliente1234 |

## Estrutura

- `app/Http/Controllers/Api/` — API pública + anunciante + cliente
- `app/Http/Controllers/Admin/` — CRM admin (Blade)
- `app/Http/Middleware/` — EstadoConta, PlanoAtivo, EnsureClienteAtivo, AdminAuth
- `app/Models/` — 24 models (Eloquent)
- `app/Services/` — ClienteAuthService, ActivityLogService, NotificacaoService
- `app/Mail/` — Mailables (Admin, Cliente)
- `database/migrations/` — 39 tabelas
- `resources/views/` — Blade templates (admin, painel, emails)
- `routes/web.php` — Rotas admin + painel (Blade)
- `routes/api.php` — Rotas API (Sanctum)

## Rotas API

```
POST /api/v1/registo              → Registo imobiliária
POST /api/v1/login                → Login imobiliária
GET  /api/v1/imoveis              → Listar imóveis
GET  /api/v1/imoveis/{id}         → Detalhe imóvel
POST /api/v1/cliente/registo      → Registo cliente
POST /api/v1/cliente/login        → Login cliente
GET  /api/v1/cliente/me           → Perfil cliente
...
```

## Documentação

Ver `../README.md` para documentação completa do projeto.
