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

(Ver "Testes (estado atual)" no fim do documento)

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
- `app/Http/Controllers/Cliente/ClienteAvaliacaoController.php` - Criar, listar, reenviar avaliacoes
- `app/Http/Controllers/Cliente/ClienteFavoritoController.php` - Adicionar, listar, remover favoritos
- `app/Http/Controllers/Cliente/ClientePesquisaController.php` - Guardar, listar, remover pesquisas
- `app/Http/Controllers/Cliente/ClientePushTokenController.php` - Registar/remover push tokens
- `app/Http/Controllers/Admin/ModeracaoController.php` - Avaliacoes, denuncias, visitas (moderacao)

### Models

- `app/Models/Imovel.php` - Imovel com accessors `media_estrelas`, `avaliacoes_count`, `tipologia`, `dormitorios`
- `app/Models/Avaliacao.php` - Avaliacoes de imoveis (estrelas 1-5, comentario, estado)
- `app/Models/PushToken.php` - Tokens de notificacao push por cliente
- `app/Models/ClienteNotificacao.php` - Notificacoes in-app para clientes
- `app/Models/ClienteFavorito.php` - Favoritos do cliente
- `app/Models/ClientePesquisa.php` - Pesquisas guardadas pelo cliente
- `app/Models/Visita.php` - Visitas agendadas a imoveis

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
- `app/Services/PushNotificationService.php` - Registo tokens, envio push, gestao tokens inativos
- `app/Services/Cliente/ClienteNotificacaoService.php` - Notificacoes in-app para clientes

### Mail

- `app/Mail/PlanoAExpirar.php` - Email aviso expiracao
- `app/Mail/PlanoExpirado.php` - Email plano expirado
- `app/Mail/VisitaConfirmada.php` - Email confirmacao visita
- `app/Mail/VisitaRecusada.php` - Email recusa visita
- `app/Mail/DisponibilidadeNotificada.php` - Email notificacao disponibilidade
- `app/Mail/ImovelAprovado.php` - Email aprovacao/rejeicao de imovel

### Jobs

- `app/Jobs/SendPagamentoRecebidoEmail.php`
- `app/Jobs/SendPagamentoConfirmadoEmail.php`
- `app/Jobs/SendPagamentoRejeitadoEmail.php`
- `app/Jobs/SendPlanoAExpirarEmail.php`
- `app/Jobs/SendPlanoExpiradoEmail.php`
- `app/Jobs/SendVisitaConfirmadaEmail.php`
- `app/Jobs/SendVisitaRecusadaEmail.php`
- `app/Jobs/SendDisponibilidadeNotificadaEmail.php`
- `app/Jobs/SendImovelAprovadoEmail.php`

### Testes

- `tests/Feature/Cliente/ClienteAuthTest.php` - 10 testes (registo, login, logout, perfil, contacto)
- `tests/Feature/Cliente/ClienteAvaliacaoTest.php` - 6 testes (criar, duplicada, estrelas, reenviar, ownership, ver)
- `tests/Feature/Cliente/ClienteFavoritoTest.php` - 6 testes (ver, adicionar, duplicado, remover, independente, nao auth)
- `tests/Feature/Cliente/ClientePesquisaTest.php` - 3 testes (guardar, duplicado, clientes diferentes)
- `tests/Feature/Cliente/ClienteVisitaTest.php` - 5 testes (ver, agendar, cancelar, ownership, nao auth)
- `tests/Feature/PagamentoTest.php` - 7 testes
- `tests/Feature/ImovelFotosTest.php` - 5 testes
- `tests/Feature/AdminSmokeTest.php` - 21 rotas admin
- `tests/Feature/AdminImobiliariaTest.php` - 8 testes
- `tests/Feature/AdminImovelTest.php` - 7 testes
- `tests/Feature/AdminPagamentoTest.php` - 5 testes (3 skipped)
- `tests/Feature/PushNotificationTest.php` - 7 testes (registrar, remover, duplicado, service, enviar, remover, nao auth)
- `tests/Feature/SmokeDebugTest.php` - 1 teste

### Migrations (Fases 17-19)

- `database/migrations/2026_09_18_101300_create_avaliacoes_table.php` - Tabela avaliacoes
- `database/migrations/2026_09_19_162000_add_cliente_id_to_avaliacoes_table.php` - Cliente FK em avaliacoes
- `database/migrations/2026_09_20_100000_create_push_tokens_table.php` - Tokens push (cliente_id, token, plataforma, ativo)
- `app/Jobs/SendVisitaConfirmadaEmail.php`
- `app/Jobs/SendVisitaRecusadaEmail.php`
- `app/Jobs/SendDisponibilidadeNotificadaEmail.php`

### Views

- `resources/views/imoveis/show.blade.php` - Pagina imovel com modal agendamento + avaliacoes
- `resources/views/painel/visitas.blade.php` - Visitas imobiliaria (tabela + modal recusa)
- `resources/views/painel/mensagens.blade.php` - Mensagens com botoes resposta/notificacao
- `resources/views/cliente/visitas.blade.php` - Lista visitas cliente
- `resources/views/cliente/avaliacoes.blade.php` - Avaliacoes do cliente (criar, listar, reenviar)
- `resources/views/cliente/favoritos.blade.php` - Lista favoritos do cliente
- `resources/views/cliente/pesquisas.blade.php` - Pesquisas guardadas do cliente
- `resources/views/admin/avaliacoes/index.blade.php` - Moderacao de avaliacoes
- `resources/views/admin/denuncias/index.blade.php` - Lista denuncias
- `resources/views/admin/denuncias/show.blade.php` - Detalhe denuncia
- `resources/views/admin/visitas/index.blade.php` - Visitas (moderacao admin)
- `resources/views/emails/visita-confirmada.blade.php`
- `resources/views/emails/visita-recusada.blade.php`
- `resources/views/emails/disponibilidade-notificada.blade.php`
- `resources/views/emails/imovel-aprovado.blade.php` - Email aprovacao/rejeicao imovel
- `resources/views/components/modal-global.blade.php` - Componente modais globais

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
- `GET /cliente/avaliacoes` - Lista avaliacoes do cliente
- `POST /cliente/avaliacoes` - Criar avaliacao (throttle:10,1)
- `POST /cliente/avaliacoes/{avaliacao}/reenviar` - Reenviar avaliacao rejeitada
- `GET /cliente/favoritos` - Lista favoritos
- `POST /cliente/favoritos/{imovel}` - Adicionar favorito
- `DELETE /cliente/favoritos/{imovel}` - Remover favorito
- `GET /cliente/pesquisas` - Lista pesquisas guardadas
- `POST /cliente/pesquisas` - Guardar pesquisa
- `DELETE /cliente/pesquisas/{pesquisa}` - Remover pesquisa
- `POST /cliente/push-tokens` - Registar push token
- `DELETE /cliente/push-tokens` - Remover push token

**Admin (autenticado):**
- `GET /admin` - Dashboard
- `GET /admin/pagamentos/{id}` - Detalhe pagamento
- `POST /admin/pagamentos/{id}/confirmar` - Confirmar pagamento
- `POST /admin/pagamentos/{id}/rejeitar` - Rejeitar pagamento
- `GET /admin/faturas/{id}/download` - Download fatura PDF
- `GET /admin/avaliacoes` - Lista avaliacoes (moderacao)
- `POST /admin/avaliacoes/{avaliacao}/aprovar` - Aprovar avaliacao
- `POST /admin/avaliacoes/{avaliacao}/rejeitar` - Rejeitar avaliacao
- `DELETE /admin/avaliacoes/{avaliacao}` - Apagar avaliacao
- `GET /admin/denuncias` - Lista denuncias
- `POST /admin/denuncias/{denuncia}/resolver` - Resolver denuncia
- `POST /admin/denuncias/{denuncia}/arquivar` - Arquivar denuncia
- `GET /admin/visitas` - Lista visitas (moderacao)
- `POST /admin/visitas/{visita}/estado` - Alterar estado visita

---

## Fase 11 - Refactor Painel Admin (Modularizacao)

### Controllers

`AdminController.php` monolitico (~1100 linhas) eliminado e dividido em 15 controllers em `app/Http/Controllers/Admin/`:

`AuthController`, `DashboardController`, `ImobiliariaController`, `ImovelController`, `PedidoController`, `PlanoController`, `SubscricaoController`, `PagamentoController`, `MensagemController`, `NotificacaoController`, `AdminUserController`, `LogController`, `ModeracaoController`, `ConteudoController`, `RelatorioController`

### Rotas

`routes/web.php` reescrito: grupo `admin.` com ~80 rotas e middleware de roles:
- `admin.role:super_admin,comercial` - moderacao/comercial
- `admin.role:super_admin,moderador` - conteudo/denuncias/faq
- `admin.role:super_admin` - planos, admins, logs, compliance

### Views e Composers

- 34 views Blade admin em `resources/views/admin/**`
- `AdminSidebarComposer` (registado para `admin.*`): 10 badges de contagem em cache 60s - corrige 500 `Undefined variable $msgNaoLidas`
- `PainelSidebarComposer` (para `layouts.painel`): badges do painel do anunciante, cache 60s por imobiliaria

## Fase 12 - Fix Output Buffer Leak (Risky Test)

| Item | Detalhe |
|------|---------|
| Sintoma | `AdminSmokeTest` risky: "did not close its own output buffers" |
| Diagnostico | Cada pagina admin abria +1 `ob_start()` sem fechar (ob_level 1->20 em 19 rotas) |
| Causa raiz | Comentario HTML no layout admin: `<!-- ... via @push('scripts') -->` - o Blade compila `@push` DENTRO de comentarios HTML, abrindo buffer que nunca fecha (sem `@endpush`) |
| Fix | Comentario reescrito sem diretiva Blade (linha ~183 de `admin/layouts/admin.blade.php`) |
| Licao | Nunca escrever `@directive` dentro de `<!-- -->`; usar `{{-- --}}` |
| Verificacao | `php artisan view:clear` apos mudar blades; suite 47/47, 0 risky |

Notas de diagnostico que podem ser uteis:
- Render HTTP completo nao vazava porque o kernel limpa buffers no terminate; render direto `view()->render()` em teste vazava
- Views compiladas ficam em `storage/framework/views/<hash>.php` (hash xxh128 com prefixo v2); `view:clear` remove orfaos

## Testes (estado atual)

85 testes, 175 assertions, 100% a passar, 3 skipped:
- ClienteAuthTest (10), PagamentoTest (7), ImovelFotosTest (5)
- ClienteAvaliacaoTest (6), ClienteFavoritoTest (6), ClientePesquisaTest (3), ClienteVisitaTest (5)
- AdminSmokeTest: 21 rotas admin renderizam 200 (inclui dashboard e relatorios)
- AdminImobiliariaTest: 8 testes (listar, detalhe, aprovar, suspender, reativar, bloquear, bulk aprovar, bulk validacao)
- AdminImovelTest: 7 testes (listar, detalhe, aprovar, rejeitar, bulk aprovar, bulk rejeitar, bulk validacao)
- AdminPagamentoTest: 5 testes (listar, detalhe, confirmar, rejeitar, faturas) — 3 skipped
- PushNotificationTest: 7 testes (registrar, remover, duplicado, service, enviar, remover service, nao autenticado)
- SmokeDebugTest: home via HTTP (`$this->get('/')`) - NUNCA renderizar `view('welcome')` direto (variaveis vem do HomeController)

## Fase 13 - Modais Personalizados

### Componente

`resources/views/components/modal-global.blade.php` — incluido nos 3 layouts (site, painel, admin).

### Funcoes JS Globais

| Funcao | Uso | Cor botao |
|--------|-----|-----------|
| `modalConfirmar(titulo, msg, onConfirmar)` | Acoes positivas (aprovar, confirmar) | Azul |
| `modalPerigo(titulo, msg, onConfirmar)` | Acoes destrutivas (apagar, cancelar) | Vermelho |
| `modalSucesso(titulo, msg)` | Feedback de sucesso | Verde |
| `modalErro(titulo, msg)` | Erros e avisos | Laranja |

### Substituicao

30 alert/confirm nativos eliminados em todo o sistema:
- Cliente: 6 (favoritos, pesquisas, visitas, imovel/show)
- Imobiliaria: 2 (destaques, imoveis/index)
- Admin: 22 (imobiliarias, imoveis, pagamentos, planos, subscricoes, avaliacoes, denuncias, conteudo, admins, pedidos, visitas)

### Ficheiros Modificados

| Camada | Ficheiros |
|--------|-----------|
| Layouts | `layouts/site.blade.php`, `layouts/painel.blade.php`, `admin/layouts/admin.blade.php` |
| Cliente | `favoritos.blade.php`, `pesquisas.blade.php`, `visitas.blade.php`, `imoveis/show.blade.php` |
| Imobiliaria | `destaques.blade.php`, `imoveis/index.blade.php` |
| Admin | 15 ficheiros em `admin/**` |

## Fase 14 - Favicon Corrigido

### Problema

Todos os layouts usavam `logo-c.svg` (315KB) como favicon. O `favicon.ico` existia em `public/` mas nao era referenciado.

### Solucao

Adicionado `<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">` em 6 ficheiros:
- `layouts/site.blade.php`
- `layouts/painel.blade.php`
- `admin/layouts/admin.blade.php`
- `admin/auth/login.blade.php`
- `painel/auth/login.blade.php`
- `painel/auth/registo.blade.php`

## Fase 15 - AdminSmokeTest Expandido

### Problema

`admin.dashboard` e `admin.relatorios` estavam excluidos do AdminSmokeTest por usarem `DATE_FORMAT` (MySQL-only).

### Solucao

Controllers ja usam agrupamento em PHP (compativel com SQLite). Rotas adicionadas ao teste:
- `admin.dashboard` (21 assertions total, antes 19)

## Fase 16 - Testes de Feature Admin

### Novos Testes

| Teste | Ficheiro | Testes |
|-------|----------|--------|
| AdminImobiliariaTest | `tests/Feature/AdminImobiliariaTest.php` | 8 (listar, detalhe, aprovar, suspender, reativar, bloquear, bulk, validacao) |
| AdminImovelTest | `tests/Feature/AdminImovelTest.php` | 7 (listar, detalhe, aprovar, rejeitar, bulk aprovar, bulk rejeitar, validacao) |
| AdminPagamentoTest | `tests/Feature/AdminPagamentoTest.php` | 5 (listar, detalhe, confirmar, rejeitar, faturas) |

### Bug Corrigido

- `emails/imovel-aprovado.blade.php`: variavel `$subject` indefinida — substituida por expressao inline

## Fase 17 - Sistema de Avaliacoes (completar)

### Melhorias

- `Imovel.php`: accessors `media_estrelas` e `avaliacoes_count` (calcula media de estrelas aprovadas)
- `imoveis/show.blade.php`: badge de rating no heading + secção completa de avaliações aprovadas

## Fase 18 - Notificacoes Push

### Componentes

| Componente | Ficheiro |
|------------|----------|
| Migration | `database/migrations/2026_09_20_100000_create_push_tokens_table.php` |
| Model | `app/Models/PushToken.php` |
| Service | `app/Services/PushNotificationService.php` |
| Controller | `app/Http/Controllers/Cliente/ClientePushTokenController.php` |
| Rotas | `routes/web.php` — `push-tokens.store` e `push-tokens.destroy` |

### Integracao com Fluxos

Push notifications adicionados a:
- `PainelController::visitaEstado()` — visita confirmada/cancelada
- `PainelController::mensagemNotificar()` — imovel disponivel/indisponivel
- `ModeracaoController::avaliacaoAprovar()` — avaliacao aprovada
- `ModeracaoController::avaliacaoRejeitar()` — avaliacao rejeitada
- `ModeracaoController::denunciaResolver()` — denuncia resolvida
- `ModeracaoController::denunciaArquivar()` — denuncia arquivada

### Servico

`PushNotificationService` — registarToken, removerToken, enviar, contarTokensAtivos, limparTokensInativos.
Atualmente loga notificacoes (pronto para integrar Web Push/FCM/OneSignal).

## Fase 19 - Testes Cliente

### Novos Testes

| Teste | Ficheiro | Testes |
|-------|----------|--------|
| ClienteAvaliacaoTest | `tests/Feature/Cliente/ClienteAvaliacaoTest.php` | 6 (criar, duplicada, estrelas invalidas, reenviar, ownership, ver) |
| ClienteFavoritoTest | `tests/Feature/Cliente/ClienteFavoritoTest.php` | 6 (ver, adicionar, duplicado, remover, independente, nao auth) |
| ClientePesquisaTest | `tests/Feature/Cliente/ClientePesquisaTest.php` | 3 (guardar, duplicado, clientes diferentes) |
| ClienteVisitaTest | `tests/Feature/Cliente/ClienteVisitaTest.php` | 5 (ver, agendar, cancelar, ownership, nao auth) |
| PushNotificationTest | `tests/Feature/PushNotificationTest.php` | 7 (registrar, remover, duplicado, service, enviar, remover service, nao auth) |

## Proximo Passo

Fases 1-19 concluidas. Proximas tarefas possiveis:
- Integrar Web Push real (webpush-php ou FCM)
- Sistema de avaliacoes de imobiliarias (nao apenas imoveis)
- Dashboard analytics para admin
- Sistema de coupons/descontos
