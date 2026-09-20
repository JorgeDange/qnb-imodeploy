<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fatura extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'numero', 'pagamento_id', 'imobiliaria_id', 'valor', 'moeda',
        'iva', 'total', 'pdf_path', 'emitida_em',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'iva' => 'decimal:2',
        'total' => 'decimal:2',
        'emitida_em' => 'datetime',
    ];

    public function pagamento(): BelongsTo
    {
        return $this->belongsTo(Pagamento::class);
    }

    public function imobiliaria(): BelongsTo
    {
        return $this->belongsTo(Imobiliaria::class);
    }

    public static function proximoNumero(): string
    {
        $ano = date('Y');
        $ultima = static::where('numero', 'like', "FT {$ano}/%")->orderByDesc('numero')->first();
        if ($ultima) {
            $num = (int) substr($ultima->numero, -4) + 1;
        } else {
            $num = 1;
        }
        return "FT {$ano}/" . str_pad($num, 4, '0', STR_PAD_LEFT);
    }
}
