<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Services\PushNotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientePushTokenController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'token' => 'required|string|max:500',
            'plataforma' => 'sometimes|string|in:web,android,ios',
        ]);

        $cliente = auth()->guard('cliente')->user();

        PushNotificationService::registrarToken(
            $cliente->id,
            $validated['token'],
            $validated['plataforma'] ?? 'web',
            $request->userAgent()
        );

        return response()->json(['sucesso' => true]);
    }

    public function destroy(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'token' => 'required|string|max:500',
        ]);

        PushNotificationService::removerToken($validated['token']);

        return response()->json(['sucesso' => true]);
    }
}
