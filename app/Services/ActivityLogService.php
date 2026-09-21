<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    public static function log(string $acao, $modelo = null, array $detalhes = []): void
    {
        // Nesta app (qnb-imobiliaria) não existe guard 'admin' — o CRM vive no qnb-admin.
        // admin_id fica null quando a ação parte do site/painel/cliente.
        $adminId = config('auth.guards.admin') ? (Auth::guard('admin')->check() ? Auth::guard('admin')->id() : null) : null;

        ActivityLog::create([
            'admin_id' => $adminId,
            'acao' => $acao,
            'modelo' => $modelo ? get_class($modelo) : null,
            'modelo_id' => $modelo?->id,
            'detalhes' => $detalhes,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
