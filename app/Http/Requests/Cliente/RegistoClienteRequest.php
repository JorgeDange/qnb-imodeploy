<?php

namespace App\Http\Requests\Cliente;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegistoClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:clientes,email'],
            'telefone' => ['nullable', 'string', 'max:50'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'aceitou_termos' => ['required', 'accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'aceitou_termos.accepted' => 'É necessário aceitar os Termos e a Política de Privacidade.',
        ];
    }
}
