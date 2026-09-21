# Fluxo de Faturação — QNB Imobiliária

## Diagrama de Estados

```
pendente ──► aguarda_aprovacao ──► paga ──► recibo gerado
    │               │
    │               ├──► rejeitada ──► (pode resubmeter)
    │               │
    │               └──► cancelada
    │
    └──► expirada (após X dias sem ação)
```

## Transições

| Ação | Estado Origem | Estado Destino | Quem |
|------|---------------|----------------|------|
| Emitir fatura | — | pendente | Sistema |
| Submeter comprovativo | pendente, rejeitada | aguarda_aprovacao | Imobiliária |
| Aprovar pagamento | aguarda_aprovacao | paga | Admin/Moderador |
| Rejeitar pagamento | aguarda_aprovacao | rejeitada | Admin/Moderador |
| Cancelar fatura | pendente, aguarda_aprovacao | cancelada | Admin |
| Expirar fatura | pendente, aguarda_aprovacao | expirada | Comando automático |

## Emails Enviados

| Evento | Destinatário | Mailable | Anexo |
|--------|-------------|----------|-------|
| Fatura emitida | Imobiliária | `FaturaEmitidaMail` | PDF fatura |
| Comprovativo submetido | Admin | `ComprovativoSubmetidoMail` | — |
| Pagamento confirmado | Imobiliária | `PagamentoConfirmadoMail` | PDF recibo |
| Comprovativo rejeitado | Imobiliária | `ComprovativoRejeitadoMail` | — |
| Fatura cancelada | Imobiliária | `FaturaCanceladaMail` | — |

## Comando de Expiração

```bash
php artisan faturas:expirar --dias=30
```

- Marca faturas `pendente` ou `aguarda_aprovacao` há mais de X dias como `expirada`
- Envia email de notificação à imobiliária
- Regista activity log

## Rotas

### Painel (Imobiliária)
- `GET /painel/faturas` — Lista de faturas
- `GET /painel/faturas/{id}` — Detalhe da fatura
- `GET /painel/faturas/{id}/download` — Download PDF fatura
- `GET /painel/faturas/{id}/recibo` — Download PDF recibo
- `POST /painel/faturas/{id}/comprovativo` — Submeter comprovativo

### Admin
- `GET /admin/faturas` — Lista de faturas (com filtro por estado)
- `GET /admin/faturas/{id}` — Detalhe da fatura
- `GET /admin/faturas/{id}/download` — Download PDF fatura
- `GET /admin/faturas/{id}/recibo` — Download PDF recibo
- `POST /admin/faturas/{id}/reenviar` — Reenviar PDF
- `POST /admin/faturas/{id}/aprovar` — Aprovar pagamento
- `POST /admin/faturas/{id}/rejeitar` — Rejeitar pagamento
- `POST /admin/faturas/{id}/cancelar` — Cancelar fatura

## Ficheiros

| Tipo | Caminho |
|------|---------|
| Migration faturas | `database/migrations/2026_09_20_140000_add_flow_columns_to_faturas_table.php` |
| Migration log | `database/migrations/2026_09_20_150000_create_fatura_emails_log_table.php` |
| Model Fatura | `app/Models/Fatura.php` |
| Model FaturaEmailLog | `app/Models/FaturaEmailLog.php` |
| FaturaService | `app/Services/FaturaService.php` |
| EmitirFaturaAction | `app/Actions/Faturas/EmitirFaturaAction.php` |
| SubmeterComprovativoAction | `app/Actions/Faturas/SubmeterComprovativoAction.php` |
| AprovarPagamentoAction | `app/Actions/Faturas/AprovarPagamentoAction.php` |
| RejeitarPagamentoAction | `app/Actions/Faturas/RejeitarPagamentoAction.php` |
| CancelarFaturaAction | `app/Actions/Faturas/CancelarFaturaAction.php` |
| Comando expirar | `app/Console/Commands/ExpirarFaturas.php` |
| Mailables | `app/Mail/FaturaEmitidaMail.php`, `ComprovativoSubmetidoMail.php`, `PagamentoConfirmadoMail.php`, `ComprovativoRejeitadoMail.php`, `FaturaCanceladaMail.php` |
| Templates email | `resources/views/emails/faturas/*.blade.php` |
| PDF fatura | `resources/views/pdf/fatura.blade.php` |
| PDF recibo | `resources/views/pdf/recibo.blade.php` |

## Queue

- Todos os emails são enviados via `Mail::queue()`
- `QUEUE_CONNECTION=database` no `.env`
- Worker: `php artisan queue:work`
- Cron: adicionar `php artisan schedule:run` ao cron do servidor
