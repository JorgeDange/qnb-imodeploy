<?php

namespace App\Console\Commands;

use App\Jobs\SendPlanoAExpirarEmail;
use App\Jobs\SendPlanoExpiradoEmail;
use App\Models\ImobiliariaPlano;
use Illuminate\Console\Command;

class VerificarPlanos extends Command
{
    protected $signature = 'planos:verificar';
    protected $description = 'Verificar planos expirados e a expirar, enviar notificações';

    public function handle(): int
    {
        $enviados = 0;

        // Planos que expiram em 7 dias
        $aExpirar = ImobiliariaPlano::where('ativo', true)
            ->where('data_expiracao', now()->addDays(7)->toDateString())
            ->where('notificado_a_expirar', false)
            ->with('imobiliaria', 'plano')
            ->get();

        foreach ($aExpirar as $assinatura) {
            SendPlanoAExpirarEmail::dispatch($assinatura);
            $assinatura->update(['notificado_a_expirar' => true]);
            $enviados++;
        }

        // Planos expirados hoje
        $expirados = ImobiliariaPlano::where('ativo', true)
            ->where('data_expiracao', '<', now()->toDateString())
            ->where('notificado_expirado', false)
            ->with('imobiliaria', 'plano')
            ->get();

        foreach ($expirados as $assinatura) {
            // Desativar plano
            $assinatura->update([
                'ativo' => false,
                'estado' => 'expirada',
                'notificado_expirado' => true,
            ]);

            SendPlanoExpiradoEmail::dispatch($assinatura);
            $enviados++;
        }

        $this->info("Verificação concluída. {$enviados} notificações enviadas.");
        return self::SUCCESS;
    }
}
