<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo SOMENTE-LEITURA da tabela `admins` (partilhada com o qnb-admin).
 *
 * A gestão de admins (CRUD, login, roles) vive exclusivamente no CRM (qnb-admin).
 * Aqui existe apenas para o painel do anunciante conseguir mostrar o nome
 * do autor das mensagens do administrador (threads admin_mensagens).
 */
class AdminUser extends Model
{
    protected $table = 'admins';

    protected $fillable = [];

    /**
     * A tabela usa `nome`; o painel mostra `->name`.
     */
    public function getNameAttribute(): string
    {
        return $this->attributes['nome'] ?? 'Admin';
    }
}
