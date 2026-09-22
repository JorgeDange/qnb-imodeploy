# QNB-Imobiliária — Guia para IA (qnb-imobiliaria)

> **Este ficheiro serve como contexto para IA assistente.** Lê-lo antes de qualquer tarefa neste projeto.

---

## 1. O Que É Este Projeto

**QNB-Imobiliária** — marketplace angolano de imóveis. Empresas/imobiliárias anunciam imóveis, contactos diretos entre anunciante e cliente. Duas apps Laravel partilham a mesma BD MySQL:

| App | Âmbito | Domínio |
|-----|--------|---------|
| **qnb-imobiliaria** (este projeto) | Site público + Painel do anunciante + Área do cliente | `www.qnbangola.com` |
| **qnb-admin** (projeto separado) | CRM Admin/Moderador | `admin.qnbangola.com` |

**Stack:** Laravel 12 + PHP 8.2+ + MySQL + Blade + HTML/CSS/JS puro (sem frontend framework)

---

## 2. Estado Atual — PRONTO PARA PRODUÇÃO

- **Testes:** 77 passed / 5 skipped (PHPUnit 11.5)
- **Mobile:** Responsiveness completa (painel + cliente) — sidebar off-canvas, bottom nav bar, cards
- **Admin:** Movido para qnb-admin (domínio separado por segurança)
- **Deploy:** Documentado em `DEPLOY.md` (VPS/Nginx ou cPanel)

---

## 3. Estrutura de Pastas

```
qnb-imobiliaria/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/                    # API pública + anunciante + cliente
│   │   │   │   ├── AuthController.php
│   │   │   │   ├── ImovelPublicoController.php
│   │   │   │   ├── AmenidadeController.php
│   │   │   │   ├── SiteController.php
│   │   │   │   ├── Painel/             # API do painel do anunciante
│   │   │   │   │   ├── DashboardController.php
│   │   │   │   │   ├── ImovelController.php
│   │   │   │   │   ├── MensagemController.php
│   │   │   │   │   ├── PerfilController.php
│   │   │   │   │   └── PlanoController.php
│   │   │   │   └── Cliente/            # API do cliente
│   │   │   │       └── ClienteAuthController.php
│   │   │   ├── Cliente/                # Views Blade do cliente (11 controllers)
│   │   │   ├── Painel/                 # Views Blade do anunciante
│   │   │   │   └── FaturaController.php
│   │   │   └── PainelController.php    # Controller monolítico do painel
│   │   └── Middleware/
│   │       ├── EstadoConta.php         # Verifica conta aprovada
│   │       ├── PlanoAtivo.php          # Verifica plano ativo
│   │       └── EnsureClienteAtivo.php  # Verifica cliente ativo
│   ├── Mail/                           # 16 Mailables
│   ├── Models/                         # 33 models Eloquent
│   └── Services/                       # 7 services
├── database/
│   ├── migrations/                     # 62 migrations
│   └── seeders/                        # 6 seeders
├── resources/views/
│   ├── layouts/                        # site.blade.php, painel.blade.php
│   ├── painel/                         # 19 views do anunciante
│   ├── cliente/                        # 14 views do cliente
│   ├── emails/                         # 17 templates de email
│   ├── pdf/                            # fatura.blade.php, recibo.blade.php
│   ├── components/                     # modal-global, flash
│   └── imoveis/                        # index, show (público)
├── routes/
│   ├── web.php                         # ~50 rotas web (Blade)
│   └── api.php                         # ~35 rotas API (Sanctum)
├── tests/                              # 18 ficheiros, 77 testes
├── public/
│   ├── assets/                         # CSS/JS/img do site
│   └── painel-assets/                  # CSS/JS do painel
├── DEPLOY.md                           # Guia de deploy completo
└── memoria.md                          # Memória do projeto (atualizar sempre)
```

---

## 4. Auth Guards

| Guard | Driver | Modelo | Uso |
|-------|--------|--------|-----|
| `web` | session | `Imobiliaria` | Default |
| `imobiliaria` | session | `Imobiliaria` | Login do anunciante |
| `cliente` | session | `Cliente` | Login do cliente (web) |
| `cliente-api` | sanctum | `Cliente` | API do cliente (tokens) |

**Passwords:** tabela partilhada `password_reset_tokens` para ambos os guards.

---

## 5. Models Principais e Relações

### Imobiliária
- `Imobiliaria` → hasMany Imovel, Mensagem, CanalContacto, Visita, Avaliacao, Pagamento
- `ImobiliariaPlano` → belongsTo Imobiliaria + Plano
- `PedidoAtivacao` → belongsTo Imobiliaria

### Imóvel
- `Imovel` → belongsTo Imobiliaria; hasMany ImovelFoto, CanalContacto, Mensagem, Denuncia, Avaliacao
- `ImovelFoto` → belongsTo Imovel (ordem + capa)
- `Amenidade` → belongsToMany Imovel (pivot: `imovel_amenidade`)

### Cliente
- `Cliente` → hasMany ClienteFavorito, Mensagem, Visita, ClientePesquisa, ClienteNotificacao, Denuncia, Avaliacao
- `ClienteFavorito` → belongsTo Cliente + Imovel
- `Visita` → belongsTo Imovel + Imobiliaria + Cliente

### Financeiro
- `Fatura` → belongsTo Imobiliaria; hasMany FaturaLinha, FaturaEmailLog
- `Pagamento` → belongsTo ImobiliariaPlano; hasOne Fatura
- `Plano` → hasMany ImobiliariaPlano

### Mensagens
- `Mensagem` → belongsTo Imobiliaria + Imovel + Cliente
- `AdminMensagem` → belongsTo Admin + Imobiliaria (thread com self-replies)

---

## 6. Controllers — Resumo

### Web (Blade)
| Controller | Rotas | Descrição |
|-----------|-------|-----------|
| `PainelController` | 33 | Dashboard, perfil, imóveis CRUD, mensagens, destaques, visitas, estatisticas, canais, password |
| `Painel\FaturaController` | 5 | Faturas do anunciante (listar, ver, submeter comprovativo) |
| `Cliente\*` (11 controllers) | 28 | Dashboard, perfil, favoritos, mensagens, visitas, pesquisas, notificações, denúncias, avaliações |
| `HomeController` | 7 | Páginas públicas (home, imóveis, contacto, sobre, como-anunciar) |

### API (Sanctum)
| Endpoint | Descrição |
|----------|-----------|
| `POST /api/v1/registo` | Registo imobiliária |
| `POST /api/v1/login` | Login imobiliária |
| `GET /api/v1/imoveis` | Listar imóveis públicos |
| `POST /api/v1/cliente/registo` | Registo cliente |
| `POST /api/v1/cliente/login` | Login cliente |
| `GET /api/v1/cliente/me` | Perfil cliente (autenticado) |

---

## 7. Services

| Service | Função |
|---------|--------|
| `ActivityLogService` | Log de auditoria (usado por observers) |
| `ClienteAuthService` | Auth do cliente (registo, login, verificação email, reset password) |
| `EmpresaConfigService` | Configurações chave-valor da empresa |
| `FaturaService` | Criação, numeração, estados, PDF de faturas |
| `InvoiceService` | Renderização PDF de faturas |
| `PagamentoService` | Processamento de pagamentos (confirmação, rejeição) |
| `PushNotificationService` | Envio de notificações push via tokens |

---

## 8. Mailables (16)

| Mailable | Contexto |
|----------|----------|
| `PagamentoConfirmado`, `PagamentoConfirmadoMail`, `PagamentoRecebido`, `PagamentoRejeitado` | Pagamentos |
| `FaturaEmitidaMail`, `FaturaCanceladaMail` | Faturas |
| `ComprovativoSubmetidoMail` | Comprovativo |
| `NovaImobiliariaRegistada` | Registo |
| `NovaMensagemRecebida` | Mensagens |
| `ImovelSubmetido` | Imóvel |
| `PedidoAtivacaoPlano`, `PlanoAExpirar`, `PlanoExpirado` | Planos |
| `VisitaConfirmada`, `VisitaRecusada` | Visitas |
| `DisponibilidadeNotificada` | Disponibilidade |

---

## 9. Middleware

| Alias | Classe | Função |
|-------|--------|--------|
| `auth` | `Authenticate` | Redirect consoante prefixo da rota (painel/cliente/admin) |
| `conta.aprovada` | `EstadoConta` | Verifica se imobiliária está aprovada |
| `plano.ativo` | `PlanoAtivo` | Verifica se imobiliária tem plano ativo |
| `cliente.ativo` | `EnsureClienteAtivo` | Verifica se cliente está ativo |

---

## 10. Observers

| Observer | Modelo | Eventos |
|----------|--------|---------|
| `ImobiliariaObserver` | `Imobiliaria` | created, updated, deleted |
| `ImovelObserver` | `Imovel` | created, updated, deleted |
| `PlanoObserver` | `Plano` | created, updated, deleted |

Todos delegam para `ActivityLogService::log()`.

---

## 11. Migrations — 62 tabelas

**Principais:**
`imobiliarias`, `imoveis`, `imovel_fotos`, `planos`, `imobiliaria_plano`, `pagamentos`, `faturas`, `fatura_linhas`, `mensagens`, `admin_mensagens`, `clientes`, `cliente_favoritos`, `visitas`, `avaliacoes`, `denuncias`, `amenidades`, `imovel_amenidade`, `canais_contacto`, `push_tokens`, `notificacoes`, `cliente_notificacoes`, `imobiliaria_notificacoes`, `activity_logs`

**Soft deletes:** imobiliarias, imoveis, clientes

---

## 12. Views — 73 templates

| Pasta | Count | Descrição |
|-------|-------|-----------|
| `layouts/` | 2 | site.blade.php (layout público), painel.blade.php (layout painel) |
| `painel/` | 19 | Dashboard, perfil, imóveis, mensagens, visitas, faturas, etc. |
| `cliente/` | 14 | Dashboard, perfil, favoritos, mensagens, visitas, etc. |
| `emails/` | 17 | Templates de email (pagamento, fatura, visita, etc.) |
| `pdf/` | 2 | fatura.blade.php, recibo.blade.php |
| `imoveis/` | 2 | index.blade.php, show.blade.php (público) |
| `components/` | 2 | modal-global, flash |

---

## 13. Mobile Responsiveness

### Painel do Anunciante
- **Sidebar:** off-canvas com hamburger toggle (≤991px)
- **Tabelas:** convertem para cards com `data-label` (≤767px)
- **Botões:** empilham verticalmente em imóveis e mensagens
- **Bottom nav bar:** fixa inferior com 5 links + badges (≤767px)

### Área do Cliente
- **Sidebar:** off-canvas com hamburger toggle (≤767px)
- **Bottom nav bar:** fixa inferior com 5 links (≤767px)
- **Cards:** já responsivos (clamp() values)

### Arquivos CSS/JS
- `public/painel-assets/css/painel.css` — seções 39–43 (media queries)
- `public/painel-assets/js/painel.js` — toggle sidebar
- `public/assets/css/cliente.css` — seções 10–11 (media queries)
- `public/assets/js/cliente.js` — toggle sidebar

---

## 14. Rotas Importantes

### Web
```
/                           → Home
/painel/login               → Login anunciante
/painel/dashboard           → Dashboard anunciante
/painel/imoveis             → Listar imóveis
/painel/imoveis/novo        → Criar imóvel
/painel/mensagens           → Mensagens
/painel/visitas             → Visitas
/painel/faturas             → Faturas
/cliente/login              → Login cliente
/cliente/dashboard          → Dashboard cliente
/cliente/favoritos          → Favoritos
/cliente/mensagens          → Mensagens
/cliente/visitas            → Visitas
/health                     → Health check (GET)
```

### API
```
POST /api/v1/registo         → Registo imobiliária
POST /api/v1/login           → Login imobiliária
GET  /api/v1/imoveis         → Listar imóveis públicos
POST /api/v1/cliente/registo → Registo cliente
POST /api/v1/cliente/login   → Login cliente
```

---

## 15. Credenciais (DEV)

| Área | Login | Senha |
|------|-------|-------|
| Painel anunciante | `demo@qnbangola.com` | `demo1234` |
| Cliente | `cliente@qnbangola.com` | `cliente1234` |
| Admin (qnb-admin) | `admin@qnbangola.com` | `admin1234` |

**⚠️ NUNCA usar em produção!**

---

## 16. Comandos Úteis

```bash
# Setup
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed

# Desenvolvimento
php artisan serve --port=8899
php artisan view:clear && php artisan view:cache

# Testes
php artisan test

# Produção
php artisan config:cache && php artisan route:cache && php artisan view:cache
php artisan migrate --force
php artisan queue:work --queue=publico
```

---

## 17. Regras para IA

1. **NUNCA correr `db:seed` completo em produção** — só `PlanosSeeder` e `AmenidadesSeeder`
2. **Admin Controllers NÃO existem aqui** — estão no qnb-admin
3. **Observers só disparam emails** — não duplicar para o qnb-admin
4. **Migrations só correm nesta app** — o qnb-admin nunca corre migrate
5. **Filas nomeadas:** `publico` (esta app) / `admin` (qnb-admin)
6. **Models são duplicados nas 2 apps** — fonte de verdade é a BD
7. **Mobile:** usar ≤767px como breakpoint principal
8. **CSS:** usar `clamp()` para valores responsivos, `var(--ul-primary)` para cores
9. **Icons:** usar Bootstrap Icons (`bi-*`), não Font Awesome
10. **Testes:** correr `php artisan test` antes de commit — 77 testes devem passar
