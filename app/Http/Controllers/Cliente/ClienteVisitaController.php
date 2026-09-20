<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Imovel;
use App\Models\Visita;
use App\Services\Cliente\InteracaoService;
use Illuminate\Http\Request;
use App\Services\Cliente\VisitaService;

class ClienteVisitaController extends Controller
{
    protected $visitaService;

    public function __construct(VisitaService $visitaService)
    {
        $this->visitaService = $visitaService;
    }

    public function index()
    {
        $visitas = auth()->guard('cliente')->user()
            ->visitas()
            ->latest()
            ->get();

        return view('cliente.visitas', compact('visitas'));
    }

    public function store(Imovel $imovel, Request $request)
    {
        $validated = $request->validate([
            'data_visita' => 'required|date|after_or_equal:today',
            'telefone' => 'sometimes|string|max:20',
        ]);

        $cliente = auth()->guard('cliente')->user();

        $visita = $this->visitaService->agendar($cliente, $imovel, $validated);

        InteracaoService::registar($cliente->id, 'visita_agendada', $imovel->id, $imovel->imobiliaria_id);

        return redirect()->route('cliente.visitas')
            ->with('sucesso', 'Solicitação de visita enviada com sucesso! Um agente entrará em contato em breve.');
    }

    public function cancelar(Visita $visita)
    {
        $cliente = auth()->guard('cliente')->user();

        if ($visita->cliente_id !== $cliente->id) {
            abort(403, 'Não tem permissão para cancelar esta visita.');
        }

        $this->visitaService->cancelar($visita);

        return back()
            ->with('sucesso', 'Visita cancelada com sucesso!');
    }

    public function diasDisponiveis(Imovel $imovel)
    {
        $diasIndisponiveis = $this->visitaService->diasIndisponiveis($imovel);

        $horarios = ['09:00', '10:00', '11:00', '14:00', '15:00', '16:00'];

        return response()->json([
            'dias_indisponiveis' => $diasIndisponiveis,
            'horarios' => $horarios,
        ]);
    }
}
