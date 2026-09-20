<?php

namespace App\Http\Requests\Cliente;

use Illuminate\Foundation\Http\FormRequest;

class RegistoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clientes',
            'telefone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser válido.',
            'email.unique' => 'Este e-mail já está registado.',
            'telefone.max' => 'O telefone deve ter no máximo 20 caracteres.',
            'password.min' => 'A password deve ter no mínimo 8 caracteres.',
            'password.confirmed' => 'As passwords não coincidem.',
            'password_confirmation.required' => 'Confirme a password.',
        ];
    }
}