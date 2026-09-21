<?php

namespace App\Http\Controllers\Painel;

use App\Actions\Faturas\SubmeterComprovativoAction;
use App\Http\Controllers\Controller;
use App\Models\Fatura;
use App\Services\FaturaService;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaturaController extends Controller
{
    public function __construct(
        private InvoiceService $invoiceService,
        private FaturaService $faturaService,
    ) {}

    public function index()
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();

        $faturas = Fatura::where('imobiliaria_id', $imobiliaria->id)
            ->with(['linhas'])
            ->orderByDesc('emitida_em')
            ->paginate(15);

        return view('painel.faturas.index', compact('faturas'));
    }

    public function show(Fatura $fatura)
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();

        if ($fatura->imobiliaria_id !== $imobiliaria->id) {
            abort(403);
        }

        $fatura->load(['linhas', 'pagamento.subscricao.plano']);

        return view('painel.faturas.show', compact('fatura'));
    }

    public function download(Fatura $fatura)
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();

        if ($fatura->imobiliaria_id !== $imobiliaria->id) {
            abort(403);
        }

        return $this->invoiceService->download($fatura);
    }

    public function downloadRecibo(Fatura $fatura)
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();

        if ($fatura->imobiliaria_id !== $imobiliaria->id) {
            abort(403);
        }

        if (!$fatura->isPaga()) {
            abort(404);
        }

        return $this->faturaService->downloadRecibo($fatura);
    }

    public function submeterComprovativo(Request $request, Fatura $fatura)
    {
        $imobiliaria = Auth::guard('imobiliaria')->user();

        if ($fatura->imobiliaria_id !== $imobiliaria->id) {
            abort(403);
        }

        if (!$fatura->isPendente() && !$fatura->isRejeitada()) {
            return back()->with('error', 'Não é possível submeter comprovativo para esta fatura.');
        }

        $validated = $request->validate([
            'comprovativo' => 'required|file|image|mimes:jpeg,png,webp,pdf|max:5120',
        ]);

        $action = app(SubmeterComprovativoAction::class);
        $action->execute($fatura, $request->file('comprovativo'), $imobiliaria->id);

        return back()->with('success', 'Comprovativo submetido com sucesso. Aguarda aprovação da equipa QNB.');
    }
}
