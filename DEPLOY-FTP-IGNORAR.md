# DEPLOY FTP — Ficheiros a EXCLUIR

> Estes ficheiros/pastas **NÃO devem ser enviados** via FTP para produção.
> Regenerados automaticamente no servidor comandos artisan.

---

## EXCLUIR (nunca subir)

```
storage/framework/views/          # ~200 compiled views (regenera com view:cache)
storage/framework/sessions/      # sessões locais (produção usa BD)
storage/framework/cache/         # cache local (produção usa BD)
storage/logs/                    # logs de debug
bootstrap/cache/                 # cache de bootstrap (regenera automaticamente)
vendor/                          # dependências (regenera com composer install)
node_modules/                    # não usado (Blade puro)
tests/                           # testes (não precisam em produção)
.git/                            # historial git
.env                             # credenciais (criar NOVO no servidor)
.env.backup                      # backup de .env
.phpunit.result.cache            # cache de testes
phpunit.xml                      # config de testes
```

---

## NÃO enviar estes seeders (mesmo que existam no servidor)

```
database/seeders/DatabaseSeeder.php       # chama seeders de demo
database/seeders/ClienteDemoSeeder.php    # passwords demo (demo1234)
database/seeders/DadosDemoSeeder.php      # dados fictícios
```

**Seeders PERMITIDOS** (executar no servidor):
```
database/seeders/PlanosSeeder.php         # planos base
database/seeders/AmenidadesSeeder.php     # amenidades base
database/seeders/EmpresaConfigSeeder.php  # configurações empresa
```

---

## Ficheiros a criar NO SERVIDOR (não existem no repo)

```
.env                                  # copiar de .env.example e configurar
storage/app/public/                   # pasta para uploads (já tem .gitignore)
public/storage                        # symlink: storage:link
```

---

## Comandos a executar NO SERVIDOR após upload

```bash
# 1. Dependências
composer install --no-dev --optimize-autoloader

# 2. Chave de app (NOVA, diferente do dev)
php artisan key:generate --force

# 3. Base de dados
php artisan migrate --force

# 4. Seeders permitidos
php artisan db:seed --force --class=PlanosSeeder
php artisan db:seed --force --class=AmenidadesSeeder
php artisan db:seed --force --class=EmpresaConfigSeeder

# 5. Symlink de uploads
php artisan storage:link

# 6. Caches (regenera o que foi excluído)
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Permissões (Linux/cPanel)
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## Resumo rápido (copiar para ignorar no FTP)

```
storage/framework/views/
storage/framework/sessions/
storage/framework/cache/
storage/logs/
bootstrap/cache/
vendor/
node_modules/
tests/
.git/
.env
.env.backup
.phpunit.result.cache
phpunit.xml
```
