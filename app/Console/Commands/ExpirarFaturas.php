<?php

namespace App\Console\Commands;

use App\Models\Fatura;
use App\Services\FaturaService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ExpirarFaturas extends Command
{
    protected $signature = 'faturas:expirar {--dias=30 : Dias sem ação para expirar}';
    protected $description = 'Expirar faturas pendentes ou em espera há mais de X dias';

    public function handle(): int
    {
        $dias = (int) $this->option('dias');
        $dataLimite = now()->subDays($dias);

        $faturas = Fatura::whereIn('estado', ['pendente', 'aguarda_aprovacao'])
            ->where('emitida_em', '<=', $dataLimite)
            ->with('imobiliaria')
            ->get();

        if ($faturas->isEmpty()) {
            $this->info("Nenhuma fatura para expirar (>${dias} dias).");
            return Command::SUCCESS;
        }

        $count = 0;

        foreach ($faturas as $fatura) {
            $fatura->update([
                'estado' => 'expirada',
                'motivo_rejeicao' => "Fatura expirada automaticamente após {$dias} dias sem ação.",
            ]);

            // Enviar email
            $imobiliaria = $fatura->imobiliaria;
            if ($imobiliaria && $imobiliaria->email) {
                Mail::to($imobiliaria->email)->send(
                    new \App\Mail\FaturaCanceladaMail($fatura)
                );

                $faturaService = app(FaturaService::class);
                $faturaService->registrarEmail($fatura, 'fatura_expirada', $imobiliaria->email);
            }

            // Activity log
            \App\Services\ActivityLogService::log('fatura_expirada', $fatura, [
                'fatura_numero' => $fatura->numero,
                'imobiliaria_id' => $fatura->imobiliaria_id,
                'dias' => $dias,
            ]);

            $count++;
        }

        $this->info("{$count} fatura(s) expirada(s) com sucesso.");
        return Command::SUCCESS;
    }
}
