<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cliente\LoginRequest;
use App\Http\Requests\Cliente\RegistoRequest;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteAuthController extends Controller
{
    public function showLogin()
    {
        return view('cliente.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::guard('cliente')->attempt($credentials, $request->filled('remember'))) {
            $cliente = Auth::guard('cliente')->user();

            if ($cliente && !$cliente->estaAtivo()) {
                Auth::guard('cliente')->logout();

                return back()
                    ->withInput($request->only('email'))
                    ->with('error', 'Sua conta encontra-se inativa. Por favor, contacte o suporte.');
            }

            $request->session()->regenerate();

            return redirect()->intended(route('cliente.dashboard'));
        }

        return back()
            ->withInput($request->only('email'))
            ->with('error', 'As credenciais fornecidas não correspondem aos nossos registos.');
    }

    public function showRegisto()
    {
        return view('cliente.auth.registro');
    }

    public function registo(RegistoRequest $request)
    {
        $validated = $request->validated();

        $cliente = Cliente::create([
            'nome' => $validated['nome'],
            'email' => $validated['email'],
            'telefone' => $validated['telefone'],
            'password' => bcrypt($validated['password']),
            'estado' => 'ativo',
            'foto' => 'assets/img/logo-c.svg',
        ]);

        if ($cliente) {
            Auth::guard('cliente')->login($cliente);

            return redirect()->route('cliente.dashboard')
                ->with('sucesso', 'Conta criada com sucesso! Seja bem-vindo à Área do Cliente.');
        }

        return back()
            ->withInput($request->only('nome', 'email'))
            ->with('error', 'Não foi possível criar a conta. Por favor, tente novamente.');
    }

    public function logout(Request $request)
    {
        Auth::guard('cliente')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
