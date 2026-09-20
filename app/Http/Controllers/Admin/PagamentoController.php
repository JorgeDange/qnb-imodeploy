<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendPagamentoConfirmadoEmail;
use App\Jobs\SendPagamentoRejeitadoEmail;
use App\Models\Fatura;
use App\Models\Pagamento;
use App\Services\PagamentoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagamentoController extends Controller
{
    public function index(Request $request)
    {
        $query = Pagamento::with(['imobiliaria', 'subscricao.plano']);

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $pagamentos = $query->orderByDesc('created_at')->paginate(15);
        return view('admin.pagamentos.index', compact('pagamentos'));
    }

    public function show(Pagamento $pagamento)
    {
        $pagamento->load(['imobiliaria', 'subscricao.plano', 'confirmadoPor', 'fatura']);
        return view('admin.pagamentos.show', compact('pagamento'));
    }

    public function confirmar(Pagamento $pagamento)
    {
        $admin = Auth::guard('admin')->user();

        $service = new PagamentoService();
        $service->confirmarPagamento($pagamento, $admin->id);

        // Notificar cliente
        SendPagamentoConfirmadoEmail::dispatch($pagamento);

        return back()->with('success', 'Pagamento confirmado, plano ativado e fatura gerada.');
    }

    public function rejeitar(Request $request, Pagamento $pagamento)
    {
        $validated = $request->validate([
            'motivo' => 'nullable|string|max:500',
        ]);

        $pagamento->update([
            'estado' => 'rejeitado',
            'motivo_rejeicao' => $validated['motivo'] ?? null,
        ]);

        // Notificar cliente
        SendPagamentoRejeitadoEmail::dispatch($pagamento);

        return back()->with('success', 'Pagamento rejeitado e cliente notificado.');
    }

    public function faturas()
    {
        $faturas = Fatura::with(['pagamento', 'imobiliaria'])->orderByDesc('emitida_em')->paginate(15);
        return view('admin.faturas.index', compact('faturas'));
    }

    public function faturaDownload(Fatura $fatura)
    {
        $service = new PagamentoService();
        return $service->downloadFatura($fatura);
    }
}
