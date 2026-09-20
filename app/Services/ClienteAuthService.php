<?php

namespace App\Services;

use App\Mail\Cliente\BemVindoClienteMail;
use App\Mail\Cliente\RecuperarPasswordClienteMail;
use App\Mail\Cliente\VerificarEmailClienteMail;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ClienteAuthService
{
    public function registar(array $dados): Cliente
    {
        return DB::transaction(function () use ($dados) {
            $cliente = Cliente::create([
                'nome'              => $dados['nome'],
                'email'             => $dados['email'],
                'telefone'          => $dados['telefone'] ?? null,
                'password'          => Hash::make($dados['password']),
                'aceitou_termos_em' => now(),
                'aceitou_termos_ip' => request()->ip(),
                'estado'            => 'ativo',
            ]);

            Mail::to($cliente->email)->queue(new BemVindoClienteMail($cliente));
            $this->enviarVerificacaoEmail($cliente);

            return $cliente;
        });
    }

    public function login(string $email, string $password, string $deviceName = 'web'): array
    {
        $cliente = Cliente::where('email', $email)->first();

        if (!$cliente || !Hash::check($password, $cliente->password)) {
            throw ValidationException::withMessages([
                'email' => ['Credenciais inválidas.'],
            ]);
        }

        if ($cliente->estado === 'suspenso') {
            throw ValidationException::withMessages([
                'email' => ['A tua conta está suspensa. Contacta o suporte.'],
            ]);
        }

        if ($cliente->estado === 'bloqueado') {
            throw ValidationException::withMessages([
                'email' => ['A tua conta está bloqueada.'],
            ]);
        }

        $cliente->update([
            'ultimo_login' => now(),
            'ultimo_ip'    => request()->ip(),
        ]);

        $token = $cliente->createToken($deviceName)->plainTextToken;

        return [
            'cliente' => $cliente,
            'token'   => $token,
        ];
    }

    public function logout(Cliente $cliente): void
    {
        $cliente->currentAccessToken()?->delete();
    }

    public function enviarVerificacaoEmail(Cliente $cliente): void
    {
        if ($cliente->emailVerificado()) {
            return;
        }

        $token = $cliente->gerarToken('verificacao_email', 60 * 24);
        Mail::to($cliente->email)->queue(new VerificarEmailClienteMail($cliente, $token));
    }

    public function verificarEmail(string $token): Cliente
    {
        $clienteToken = \App\Models\ClienteToken::where('token', hash('sha256', $token))
            ->where('tipo', 'verificacao_email')
            ->whereNull('usado_em')
            ->where('expira_em', '>', now())
            ->first();

        if (!$clienteToken) {
            throw ValidationException::withMessages([
                'token' => ['Token inválido ou expirado.'],
            ]);
        }

        $cliente = $clienteToken->cliente;
        $cliente->update(['email_verificado_em' => now()]);
        $clienteToken->update(['usado_em' => now()]);

        return $cliente;
    }

    public function enviarRecuperacaoPassword(string $email): void
    {
        $cliente = Cliente::where('email', $email)->firstOrFail();
        $token = $cliente->gerarToken('recuperacao_password', 60);
        Mail::to($cliente->email)->queue(new RecuperarPasswordClienteMail($cliente, $token));
    }

    public function redefinirPassword(string $email, string $token, string $novaPassword): Cliente
    {
        $cliente = Cliente::where('email', $email)->firstOrFail();

        $clienteToken = $cliente->validarToken($token, 'recuperacao_password');

        if (!$clienteToken) {
            throw ValidationException::withMessages([
                'token' => ['Token inválido ou expirado.'],
            ]);
        }

        $cliente->update(['password' => Hash::make($novaPassword)]);
        $clienteToken->update(['usado_em' => now()]);

        $cliente->tokens()->delete();

        return $cliente;
    }
}
