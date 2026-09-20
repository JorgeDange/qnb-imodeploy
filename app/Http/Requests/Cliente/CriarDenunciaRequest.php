<?php

namespace App\Http\Requests\Cliente;

use Illuminate\Foundation\Http\FormRequest;

class CriarDenunciaRequest extends FormRequest
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
            'motivo' => [
                'required',
                'in:spam,informacao_falsa,imovel_inexistente,preco_incorreto,violacao,outro',
            ],
            'descricao' => [
                'required',
                'string',
                'min:10',
                'max:2000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'imovel_id.required' => 'O imóvel é obrigatório.',
            'imovel_id.exists' => 'O imóvel selecionado não existe.',
            'motivo.required' => 'O motivo é obrigatório.',
            'motivo.in' => 'O motivo selecionado não é válido.',
            'descricao.required' => 'A descrição é obrigatória.',
            'descricao.min' => 'A descrição deve ter pelo menos 10 caracteres.',
            'descricao.max' => 'A descrição não pode ter mais de 2000 caracteres.',
        ];
    }
}
