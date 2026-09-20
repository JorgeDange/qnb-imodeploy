<?php

namespace App\Http\Controllers\Api\Painel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PerfilController extends Controller
{
    public function show(Request $request)
    {
        $imobiliaria = $request->user()->load('canais');
        return response()->json([
            'imobiliaria' => $imobiliaria->makeHidden(['password', 'remember_token']),
        ]);
    }

    public function update(Request $request)
    {
        $imobiliaria = $request->user();

        $validados = $request->validate([
            'nome' => ['sometimes', 'string', 'max:255'],
            'nif' => ['sometimes', 'nullable', 'string', 'max:50', Rule::unique('imobiliarias')->ignore($imobiliaria->id)],
            'telefone' => ['sometimes', 'string', 'max:50'],
            'provincia' => ['sometimes', 'nullable', 'string', 'max:100'],
            'municipio' => ['sometimes', 'nullable', 'string', 'max:100'],
            'password' => ['sometimes', 'nullable', 'string', 'min:6', 'confirmed'],
        ]);

        if (!empty($validados['password'])) {
            $validados['password'] = bcrypt($validados['password']);
        } else {
            unset($validados['password']);
        }

        $imobiliaria->update($validados);

        return response()->json([
            'mensagem' => 'Perfil atualizado.',
            'imobiliaria' => $imobiliaria->makeHidden(['password', 'remember_token']),
        ]);
    }
}
