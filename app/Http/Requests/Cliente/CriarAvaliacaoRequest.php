<?php

namespace App\Http\Requests\Cliente;

use Illuminate\Foundation\Http\FormRequest;

class CriarAvaliacaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guard('cliente')->check();
    }

    public function rules(): array
    {
        return [
            'imovel_id' => [
                'required',
                'integer',
                'exists:imoveis,id',
            ],
            'estrelas' => [
                'required',
                'integer',
                'min:1',
                'max:5',
            ],
            'comentario' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'imovel_id.required' => 'O imóvel é obrigatório.',
            'imovel_id.exists' => 'O imóvel selecionado não existe.',
            'estrelas.required' => 'A classificação em estrelas é obrigatória.',
            'estrelas.min' => 'A classificação mínima é 1 estrela.',
            'estrelas.max' => 'A classificação máxima é 5 estrelas.',
            'comentario.max' => 'O comentário não pode ter mais de 2000 caracteres.',
        ];
    }
}
