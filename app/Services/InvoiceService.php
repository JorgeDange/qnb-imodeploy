<?php

namespace App\Services;

use App\Models\Fatura;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class InvoiceService
{
    public function gerarPdf(Fatura $fatura): string
    {
        $fatura->load(['pagamento', 'imobiliaria', 'pagamento.subscricao.plano']);

        $pdf = Pdf::loadView('pdf.fatura', ['fatura' => $fatura]);
        $pdf->setPaper('a4');

        $nomeFicheiro = 'faturas/' . str_replace('/', '-', $fatura->numero) . '.pdf';
        $caminhoCompleto = storage_path('app/public/' . $nomeFicheiro);

        // Garantir que a pasta existe
        if (!is_dir(storage_path('app/public/faturas'))) {
            mkdir(storage_path('app/public/faturas'), 0755, true);
        }

        file_put_contents($caminhoCompleto, $pdf->output());

        $fatura->update(['pdf_path' => $nomeFicheiro]);

        return $nomeFicheiro;
    }

    public function download(Fatura $fatura)
    {
        if (!$fatura->pdf_path || !Storage::disk('public')->exists($fatura->pdf_path)) {
            $this->gerarPdf($fatura);
        }

        return Storage::disk('public')->download(
            $fatura->pdf_path,
            'Fatura-' . $fatura->numero . '.pdf'
        );
    }
}
