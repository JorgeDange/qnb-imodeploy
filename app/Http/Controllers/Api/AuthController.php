<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Imobiliaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function registo(Request $request)
    {
        $validados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'nif' => ['nullable', 'string', 'max:50', Rule::unique('imobiliarias')],
            'email' => ['required', 'email', 'max:255', Rule::unique('imobiliarias')],
            'telefone' => ['required', 'string', 'max:50'],
            'provincia' => ['nullable', 'string', 'max:100'],
            'municipio' => ['nullable', 'string', 'max:100'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $imobiliaria = Imobiliaria::create($validados + ['estado' => 'pendente']);

        return response()->json([
            'mensagem' => 'Conta criada. Aguarda aprovação da equipa QNB.',
            'imobiliaria' => $imobiliaria->only('id', 'nome', 'email', 'estado'),
        ], 201);
    }

    public function login(Request $request)
    {
        $validados = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($validados)) {
            return response()->json(['mensagem' => 'Credenciais inválidas.'], 401);
        }

        /** @var Imobiliaria $imobiliaria */
        $imobiliaria = Auth::user();
        $token = $imobiliaria->createToken('painel');

        return response()->json([
            'token' => $token->plainTextToken,
            'imobiliaria' => [
                'id' => $imobiliaria->id,
                'nome' => $imobiliaria->nome,
                'email' => $imobiliaria->email,
                'estado' => $imobiliaria->estadoAtual(),
            ],
        ]);
    }

    public function me(Request $request)
    {
        return response()->json(['imobiliaria' => $request->user()->makeHidden(['password'])]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['mensagem' => 'Sessão terminada.']);
    }
}
