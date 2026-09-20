<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ClientePerfilController extends Controller
{
    public function edit()
    {
        $cliente = auth()->guard('cliente')->user();

        return view('cliente.perfil', compact('cliente'));
    }

    public function update(Request $request)
    {
        $cliente = auth()->guard('cliente')->user();

        $validated = $request->validate([
            'nome' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255|unique:clientes,email,' . $cliente->id,
            'telefone' => 'sometimes|string|max:20',
        ]);

        $cliente->update($validated);

        return redirect()->back()
            ->with('sucesso', 'Perfil atualizado com sucesso!');
    }

    public function updatePassword(Request $request)
    {
        $cliente = auth()->guard('cliente')->user();

        $validated = $request->validate([
            'password_atual' => 'required|string|current_password',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ]);

        if (!Hash::check($validated['password_atual'], $cliente->password)) {
            return redirect()->back()
                ->with('error', 'A password atual não está correta.');
        }

        $cliente->password = $validated['password'];
        $cliente->save();

        return redirect()->back()
            ->with('sucesso', 'Password atualizada com sucesso!');
    }

    public function uploadFoto(Request $request)
    {
        $cliente = auth()->guard('cliente')->user();

        if (!$cliente->podeUploadFoto()) {
            return redirect()->back()
                ->with('error', 'Só pode alterar a foto uma vez por mês. Tente novamente em ' . $cliente->diasParaProximoUpload() . ' dia(s).');
        }

        $validated = $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,webp|max:2048',
        ]);

        if ($cliente->foto && !str_starts_with($cliente->foto, 'assets/')) {
            Storage::disk('public')->delete($cliente->foto);
        }

        $caminho = $request->file('foto')->store('clientes/perfil', 'public');

        $cliente->update([
            'foto' => $caminho,
            'foto_upload_em' => now(),
        ]);

        return redirect()->back()
            ->with('sucesso', 'Foto de perfil atualizada com sucesso!');
    }
}
