# Memoria do Projeto QNB-Imobiliaria

## Visao Geral

Plataforma marketplace angolana de imoveis com sistema de gestao para imobiliarias, clientes e administradores.

- **Stack:** Laravel 12 + MySQL + Sanctum + Blade
- **PHP:** 8.2.12 | PHPUnit: 11.5.56 | Windows/PowerShell
- **Design:** Congelado - apenas conectar dados via Blade, sem alterar HTML/CSS/JS visual
- **Projeto:** `C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria`

---

## Regras Fundamentais

- `finalidade` enum: apenas `arrendar` e `vender` (sem `comprar`)
- `tipo` enum BD: `apartamento,vivenda,terreno,loja,escritorio,armazem,quintal` (7 valores)
- Campo mapping form BD: `tipologia` -> `tipo`, `dormitorios` -> `quartos`, `banheiros` -> `wc`, `area_construida` -> `area`, `rua` -> `endereco`
- Removidos do form: `area_terreno`, `latitude`, `longitude`
- Fotos: validacao `min:5, max:10`
- Auth: guards `cliente` (session) + `imobiliaria` (session) + `cliente-api` (sanctum)
- Plano ativação: WhatsApp removido, fluxo in-app com submissao de pagamento + validacao admin
- Sessao expirada: redirect para login com flash message (nao JSON)

---

## Fases de Desenvolvimento

### Fase 1 - Correcoes Criticas

| Problema | Solucao | Ficheiro |
|----------|---------|----------|
| bcrypt() duplo | Removido | PainelController.php |
| Sem middleware auth | Aplicado `conta.aprovada` | web.php |
| Campos form nao mapeados | tipologia->tipo, etc. | PainelController, form.blade |
| Enum tipo errado | Alinhado com BD (7 valores) | Migrations, Controller |
| Sem throttle login | Adicionado `throttle:5,1` | web.php |
| $mensagem errado | -> $mensagem->contacto | Mail classes |
| JS seletores quebrados | `ul-painel-*` corrigidos | painel.js |

### Fase 2 - Fotos (min 5, max 10)

- Validacao `min:5, max: 10` no controller e form
- Mensagens de erro customizadas

### Fase 3 - Submissao de Pagamento (In-App)

- `PagamentoService`: criarPagamento(), confirmarPagamento()
- 5 rotas: pagamento.novo, .salvar, .confirmado, pagamentos, pagamentos.show
- 4 views: novo, confirmado, index, show
- `SendPagamentoRecebidoEmail` Job + Mail + Template
- ativar-plane.blade.php com botao in-app

### Fase 4 - Historico de Pagamentos

- Index com paginacao
- Show com detalhes e download de fatura

### Fase 5 - Validacao de Pagamento pelo Admin

- `pagamentoConfirmar()`: ativa plano + gera fatura
- `pagamentoRejeitado()`: aceita motivo
- Mail + Job para confirmacao e rejeicao
- 2 email templates (confirmado, rejeitado)
- Admin show view com botoes confirmar/rejeitar
- Rota `admin.pagamentos.show`

### Fase 6 - Fatura PDF

- `barryvdh/laravel-dompdf` v3.1 instalado
- `InvoiceService`: gerarPdf(), download()
- Template PDF `pdf/fatura.blade.php` (A4 profissional)
- Rotas download (cliente + admin)
- PDF gerado automaticamente ao confirmar pagamento
- Botoes download nas views

### Fase 7 - Notificacoes Automaticas

- Mail + Job `PlanoAExpirar` / `PlanoExpirado`
- 2 templates email
- Comando artisan `planos:verificar`
- Dashboard com alertas (expirado / por expirar)
- Sidebar badge (! vermelho / Nd amarelo)
- Bloqueio criacao imoveis sem plano ativo

### Fase 8 - Integridade e Testes

| Tarefa | Estado |
|--------|--------|
| Enum `pedidos_ativacao.estado` corrigido | Completo |
| Variavel `$estatisticas` -> `$stats` | Completo |
| `$planos` passado para `pedidoShow` | Completo |
| `duracao_dias` -> `dias_validade` | Completo |
| Testes PagamentoTest | 7/7 passam |
| Testes ImovelFotosTest | 5/5 passam |
| Testes ClienteAuthTest | 10/10 passam |
| Documentacao producao | PRODUCAO-NOTIFICACOES.md |

### Fase 9 - Sessao Expirada (Redirect)

| Middleware | Antes | Depois |
|-----------|-------|--------|
| Authenticate (Laravel) | JSON 401 | Redirect + flash error |
| PlanoAtivo | JSON 403 | Redirect ativar-plano |
| EnsureAdminHasRole | abort(403) HTML | Redirect + flash error |
| EstadoConta | Redirect ok | OK |
| EnsureClienteAtivo | Redirect ok | OK |

Login views atualizadas para mostrar `session('error')`:
- painel/auth/login.blade.php
- admin/auth/login.blade.php
- cliente/auth/login.blade.php

### Fase 10 - Sistema de Visitas e Agendamento

#### 10.1 VisitaService (Corrigido)

- Removido campo `token` (nao existe na BD)
- Adicionado `imobiliaria_id` ao criar visita
- Novos metodos: `aceitar()`, `recusar()`, `concluir()`
- `diasIndisponiveis()`: retorna datas ocupadas para um imovel
- `horariosDisponiveis()`: retorna horarios livres para uma data

#### 10.2 Estados da Visita

```
PENDENTE ──────► CONFIRMADA ──────► CONCLUIDA
    │                  │
    └──────────► CANCELADA
```

| Transicao | Quem | Acao |
|-----------|------|------|
| pendente -> confirmada | Imobiliaria | Aceitar visita |
| pendente -> cancelada | Imobiliaria | Recusar visita (com motivo) |
| confirmada -> concluida | Imobiliaria | Marcar como concluida |
| confirmada -> cancelada | Imobiliaria/Cliente | Cancelar visita |

#### 10.3 Painel Imobiliaria - Visitas

- Tabela completa com: Imovel, Cliente, Contacto, Data/Hora, Estado, Acoes
- Botoes: Aceitar, Recusar (abre modal com motivo), Concluir
- 4 estatisticas: Hoje, Pendentes, Confirmadas, Concluidas
- Modal de recusa com campo obrigatorio de motivo

#### 10.4 Painel Imobiliaria - Mensagens

- Botoes de resposta: Contactar (email/telefone), WhatsApp, Notificar Disponibilidade
- Deteccao automatica de email vs telefone no campo `contacto`
- Botao "Disp." ou "Indisp." consoante estado do imovel
- Notificacao envia email ao cliente com link para ver imoveis

#### 10.5 Cliente - Agendamento de Visitas

- Botao "Agendar Visita" na pagina do imovel (imoveis/show.blade.php)
- Modal com calendario interno (JavaScript puro)
- Dias indisponiveis carregados via AJAX (`/cliente/imoveis/{id}/dias-disponiveis`)
- Horarios: 09:00, 10:00, 11:00, 14:00, 15:00, 16:00
- Bloqueio de: passado, domingo, dias ocupados
- Submissao via POST para `cliente.visitas.store`

#### 10.6 Cliente - Lista de Visitas

- Cards com borda colorida por estado (pendente=laranja, confirmada=verde, concluida=azul, cancelada=vermelho)
- Botoes: Cancelar (pendente/confirmada), Reagendar (cancelada)
- Mensagem de observacoes (motivo da recusa)

#### 10.7 Emails Automaticos

| Evento | Destinatario | Template |
|--------|-------------|----------|
| Visita confirmada | Cliente | visita-confirmada.blade.php |
| Visita recusada | Cliente | visita-recusada.blade.php |
| Notificar disponibilidade | Cliente | disponibilidade-notificada.blade.php |

---

## Testes

22 testes a passar (100%):

- **ClienteAuthTest**: 10 testes (registo, login, logout, perfil, contacto)
- **PagamentoTest**: 7 testes (formulario, submissao, historico, detalhe, validacoes)
- **ImovelFotosTest**: 5 testes (min 5, max 10, rejeicao sem plano)

---

## Stack Tecnico

### Dependencias

- `barryvdh/laravel-dompdf` v3.1 - Geracao de faturas PDF
- `laravel/sanctum` - API tokens para cliente-api
- `laravel/framework` v12 - Framework principal

### Comandos Artisan

```
php artisan planos:verificar    # Verificar planos expirados e enviar emails
php artisan queue:work           # Processar jobs de email
php artisan storage:link         # Criar link para uploads
```

### Configuracao Producao

Ver `PRODUCAO-NOTIFICACOES.md` para:
- Configuracao SMTP
- Fila de jobs (database/redis)
- Supervisor para workers
- Cron job para planos:verificar
- Lista de verificacao pre-producao

---

## Ficheiros Principais

### Controllers

- `app/Http/Controllers/PainelController.php` - Auth imobiliaria, imoveis, pagamentos, visitas, mensagens (~650 linhas)
- `app/Http/Controllers/AdminController.php` - Admin pagamentos, faturas, pedidos (~1100 linhas)
- `app/Http/Controllers/Cliente/ClienteVisitaController.php` - Agendamento cliente (diasDisponiveis, store, cancelar)

### Middleware

- `app/Http/Middleware/Authenticate.php` - Override Laravel default para redirect
- `app/Http/Middleware/EstadoConta.php` - Redireciona pendentes
- `app/Http/Middleware/PlanoAtivo.php` - Bloqueia sem plano
- `app/Http/Middleware/AdminAuth.php` - Guard admin
- `app/Http/Middleware/EnsureAdminHasRole.php` - Role check
- `app/Http/Middleware/EnsureClienteAtivo.php` - Cliente ativo

### Services

- `app/Services/PagamentoService.php` - Logica de pagamentos
- `app/Services/InvoiceService.php` - Geracao de faturas PDF
- `app/Services/Cliente/VisitaService.php` - Agendamento, aceitar, recusar, concluir, dias/horarios disponiveis

### Mail

- `app/Mail/PlanoAExpirar.php` - Email aviso expiracao
- `app/Mail/PlanoExpirado.php` - Email plano expirado
- `app/Mail/VisitaConfirmada.php` - Email confirmacao visita
- `app/Mail/VisitaRecusada.php` - Email recusa visita
- `app/Mail/DisponibilidadeNotificada.php` - Email notificacao disponibilidade

### Jobs

- `app/Jobs/SendPagamentoRecebidoEmail.php`
- `app/Jobs/SendPagamentoConfirmadoEmail.php`
- `app/Jobs/SendPagamentoRejeitadoEmail.php`
- `app/Jobs/SendPlanoAExpirarEmail.php`
- `app/Jobs/SendPlanoExpiradoEmail.php`
- `app/Jobs/SendVisitaConfirmadaEmail.php`
- `app/Jobs/SendVisitaRecusadaEmail.php`
- `app/Jobs/SendDisponibilidadeNotificadaEmail.php`

### Views

- `resources/views/imoveis/show.blade.php` - Pagina imovel com modal agendamento
- `resources/views/painel/visitas.blade.php` - Visitas imobiliaria (tabela + modal recusa)
- `resources/views/painel/mensagens.blade.php` - Mensagens com botoes resposta/notificacao
- `resources/views/cliente/visitas.blade.php` - Lista visitas cliente
- `resources/views/emails/visita-confirmada.blade.php`
- `resources/views/emails/visita-recusada.blade.php`
- `resources/views/emails/disponibilidade-notificada.blade.php`

### Rotas Principais (routes/web.php)

**Painel Imobiliaria (autenticado):**
- `GET /painel` - Dashboard
- `GET/POST /painel/imoveis/criar` - Criar imovel
- `GET /painel/pagamento/novo` - Formulario pagamento
- `POST /painel/pagamento/salvar` - Submeter pagamento
- `GET /painel/pagamentos` - Historico pagamentos
- `GET /painel/faturas/{id}/download` - Download fatura PDF
- `GET /painel/visitas` - Lista visitas
- `POST /painel/visitas/{id}/estado` - Aceitar/recusar/concluir visita
- `GET /painel/mensagens` - Lista mensagens
- `POST /painel/mensagens/{id}/lida` - Marcar como lida
- `POST /painel/mensagens/{id}/notificar` - Notificar disponibilidade

**Cliente (autenticado):**
- `GET /cliente/visitas` - Lista visitas
- `POST /cliente/visitas/{imovel}` - Agendar visita
- `POST /cliente/visitas/{visita}/cancelar` - Cancelar visita
- `GET /cliente/imoveis/{imovel}/dias-disponiveis` - JSON dias/horarios disponiveis

**Admin (autenticado):**
- `GET /admin` - Dashboard
- `GET /admin/pagamentos/{id}` - Detalhe pagamento
- `POST /admin/pagamentos/{id}/confirmar` - Confirmar pagamento
- `POST /admin/pagamentos/{id}/rejeitar` - Rejeitar pagamento
- `GET /admin/faturas/{id}/download` - Download fatura PDF

---

## Proximo Passo

Fase 10 concluida. Proximas tarefas possiveis:
- Adicionar mais testes para visitas e mensagens
- Implementar notificacoes push
- Dashboard admin com graficos
- Sistema de avaliacoes de imoveis
