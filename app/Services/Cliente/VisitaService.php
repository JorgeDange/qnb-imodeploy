<?php

namespace App\Services\Cliente;

use App\Models\Cliente;
use App\Models\Imovel;
use App\Models\Visita;

class VisitaService
{
    public function agendar(Cliente $cliente, Imovel $imovel, array $dados): Visita
    {
        $visita = Visita::create([
            'cliente_id' => $cliente->id,
            'imovel_id' => $imovel->id,
            'imobiliaria_id' => $imovel->imobiliaria_id,
            'cliente_nome' => $cliente->nome,
            'cliente_email' => $cliente->email,
            'data_visita' => $dados['data_visita'],
            'cliente_telefone' => $dados['telefone'] ?? $cliente->telefone,
            'estado' => 'pendente',
        ]);

        return $visita;
    }

    public function cancelar(Visita $visita): void
    {
        $visita->update(['estado' => 'cancelada']);
    }

    public function aceitar(Visita $visita): void
    {
        $visita->update(['estado' => 'confirmada']);

        if ($visita->cliente_id) {
            ClienteNotificacaoService::enviar(
                $visita->cliente_id,
                'visita',
                'Visita confirmada',
                'A sua visita ao imóvel "' . $visita->imovel->titulo . '" foi confirmada para ' . $visita->data_visita->format('d/m/Y H:i') . '.',
                route('cliente.visitas')
            );
        }
    }

    public function recusar(Visita $visita, string $motivo = null): void
    {
        $visita->update([
            'estado' => 'cancelada',
            'observacoes' => $motivo ?? 'Indisponível',
        ]);

        if ($visita->cliente_id) {
            ClienteNotificacaoService::enviar(
                $visita->cliente_id,
                'visita',
                'Visita cancelada',
                'A sua visita ao imóvel "' . $visita->imovel->titulo . '" foi cancelada' . ($motivo ? ': ' . $motivo : ' pelo anunciante.') ,
                route('cliente.visitas')
            );
        }
    }

    public function concluir(Visita $visita): void
    {
        $visita->update(['estado' => 'concluida']);

        if ($visita->cliente_id) {
            ClienteNotificacaoService::enviar(
                $visita->cliente_id,
                'visita',
                'Visita concluída',
                'A sua visita ao imóvel "' . $visita->imovel->titulo . '" foi marcada como concluída. Partilhe a sua avaliação!',
                route('cliente.avaliacoes')
            );
        }
    }

    public function diasIndisponiveis(Imovel $imovel): array
    {
        $ocupados = Visita::where('imovel_id', $imovel->id)
            ->whereIn('estado', ['pendente', 'confirmada'])
            ->where('data_visita', '>=', now()->startOfDay())
            ->pluck('data_visita')
            ->map(fn ($data) => $data->format('Y-m-d'))
            ->unique()
            ->values()
            ->toArray();

        return $ocupados;
    }

    public function horariosDisponiveis(Imovel $imovel, string $data): array
    {
        $horarios = ['09:00', '10:00', '11:00', '14:00', '15:00', '16:00'];

        $ocupados = Visita::where('imovel_id', $imovel->id)
            ->whereIn('estado', ['pendente', 'confirmada'])
            ->whereDate('data_visita', $data)
            ->pluck('data_visita')
            ->map(fn ($data) => $data->format('H:i'))
            ->toArray();

        return array_values(array_diff($horarios, $ocupados));
    }
}
