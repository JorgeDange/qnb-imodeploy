<?php

namespace App\Http\Controllers\Api\Cliente;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cliente\LoginClienteRequest;
use App\Http\Requests\Cliente\RecuperarPasswordRequest;
use App\Http\Requests\Cliente\RedefinirPasswordRequest;
use App\Http\Requests\Cliente\RegistoClienteRequest;
use App\Services\ClienteAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClienteAuthController extends Controller
{
    public function __construct(private ClienteAuthService $auth) {}

    public function registo(RegistoClienteRequest $request): JsonResponse
    {
        $cliente = $this->auth->registar($request->validated());

        $token = $cliente->createToken('web')->plainTextToken;

        return response()->json([
            'mensagem' => 'Conta criada com sucesso. Verifica o teu email.',
            'cliente'  => $cliente,
            'token'    => $token,
        ], 201);
    }

    public function login(LoginClienteRequest $request): JsonResponse
    {
        $resultado = $this->auth->login(
            $request->input('email'),
            $request->input('password'),
            $request->input('device_name', 'web')
        );

        return response()->json([
            'mensagem' => 'Login efetuado com sucesso.',
            'cliente'  => $resultado['cliente'],
            'token'    => $resultado['token'],
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->auth->logout($request->user());

        return response()->json(['mensagem' => 'Sessão terminada.']);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }

    public function verificarEmail(Request $request): JsonResponse
    {
        $request->validate(['token' => ['required', 'string']]);

        $cliente = $this->auth->verificarEmail($request->input('token'));

        return response()->json([
            'mensagem' => 'Email verificado com sucesso.',
            'cliente'  => $cliente,
        ]);
    }

    public function reenviarVerificacao(Request $request): JsonResponse
    {
        $this->auth->enviarVerificacaoEmail($request->user());

        return response()->json(['mensagem' => 'Email de verificação reenviado.']);
    }

    public function recuperarPassword(RecuperarPasswordRequest $request): JsonResponse
    {
        $this->auth->enviarRecuperacaoPassword($request->input('email'));

        return response()->json([
            'mensagem' => 'Se o email existir, receberás instruções para redefinir a password.',
        ]);
    }

    public function redefinirPassword(RedefinirPasswordRequest $request): JsonResponse
    {
        $this->auth->redefinirPassword(
            $request->input('email'),
            $request->input('token'),
            $request->input('password')
        );

        return response()->json(['mensagem' => 'Password redefinida com sucesso.']);
    }

    public function perfil(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }

    public function atualizarPerfil(Request $request): JsonResponse
    {
        $cliente = $request->user();
        $dados = $request->validate([
            'nome' => ['sometimes', 'string', 'max:255'],
            'telefone' => ['nullable', 'string', 'max:30'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (isset($dados['nome'])) $cliente->nome = $dados['nome'];
        if (isset($dados['telefone'])) $cliente->telefone = $dados['telefone'];
        if (isset($dados['password'])) $cliente->password = bcrypt($dados['password']);

        $cliente->save();

        return response()->json([
            'mensagem' => 'Perfil atualizado com sucesso.',
            'cliente' => $cliente->fresh(),
        ]);
    }

    public function favoritos(Request $request): JsonResponse
    {
        return response()->json($request->user()->favoritos()->with('imovel')->get());
    }

    public function adicionaFavorito(Request $request): JsonResponse
    {
        $request->validate(['imovel_id' => ['required', 'integer', 'exists:imoveis,id']]);
        $cliente = $request->user();

        if (!$cliente->favoritos()->where('imovel_id', $request->imovel_id)->exists()) {
            $cliente->favoritos()->create(['imovel_id' => $request->imovel_id]);
        }

        return response()->json(['mensagem' => 'Adicionado aos favoritos.']);
    }

    public function removeFavorito(Request $request, $id): JsonResponse
    {
        $request->user()->favoritos()->where('imovel_id', $id)->delete();
        return response()->json(['mensagem' => 'Removido dos favoritos.']);
    }

    public function mensagens(Request $request): JsonResponse
    {
        return response()->json($request->user()->mensagens()->with('imovel')->latest()->get());
    }

    public function visitas(Request $request): JsonResponse
    {
        return response()->json($request->user()->visitas()->with('imovel')->latest()->get());
    }

    public function agendarVisita(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'imovel_id'    => ['required', 'integer', 'exists:imoveis,id'],
            'data_visita'  => ['required', 'date', 'after:now'],
            'observacoes'  => ['nullable', 'string'],
        ]);

        $cliente = $request->user();
        $imovel = \App\Models\Imovel::find($dados['imovel_id']);

        $visita = $cliente->visitas()->create([
            'imovel_id'      => $dados['imovel_id'],
            'imobiliaria_id' => $imovel->imobiliaria_id,
            'cliente_nome'   => $cliente->nome,
            'cliente_email'  => $cliente->email,
            'cliente_telefone' => $cliente->telefone,
            'data_visita'    => $dados['data_visita'],
            'estado'         => 'pendente',
            'observacoes'    => $dados['observacoes'] ?? null,
        ]);

        return response()->json([
            'mensagem' => 'Visita agendada com sucesso.',
            'visita' => $visita->load('imovel'),
        ], 201);
    }
}
