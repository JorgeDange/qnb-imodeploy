@extends('layouts.painel')

@section('title', $thread->assunto . ' — Painel | QNB-Imobiliária')

@section('content')
<div class="ul-painel-head">
    <div>
        <h3 class="ul-painel-card-titulo" style="margin-bottom:4px;">{{ $thread->assunto ?? 'Sem assunto' }}</h3>
        <p class="ul-painel-card-subtitulo" style="margin-bottom:0;">Conversa com o administrador.</p>
    </div>
    <div>
        <a href="{{ route('painel.admin-mensagens') }}" class="ul-btn ul-btn--cinza">Voltar</a>
    </div>
</div>

@if(session('sucesso'))
<div class="ul-alert ul-alert--sucesso">{{ session('sucesso') }}</div>
@endif

<div class="row">
    <div class="col-lg-8">
        {{-- Mensagem Original --}}
        <div class="ul-painel-card" style="border-left:4px solid #3b82f6;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                <div>
                    <strong style="color:#3b82f6;">{{ $thread->admin->name ?? 'Admin' }}</strong>
                    <span style="color:#888;font-size:12px;margin-left:8px;">{{ $thread->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <span class="ul-badge ul-badge--azul">Admin</span>
            </div>
            <p style="margin:0;white-space:pre-wrap;">{{ $thread->texto }}</p>
        </div>

        {{-- Respostas --}}
        @forelse($thread->respostas as $resposta)
        <div class="ul-painel-card" style="border-left:4px solid {{ $resposta->autor_tipo === 'admin' ? '#3b82f6' : '#10b981' }}; margin-left:20px;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                <div>
                    <strong style="color:{{ $resposta->autor_tipo === 'admin' ? '#3b82f6' : '#10b981' }};">
                        {{ $resposta->autor_tipo === 'admin' ? ($resposta->admin->name ?? 'Admin') : $imobiliaria->nome }}
                    </strong>
                    <span style="color:#888;font-size:12px;margin-left:8px;">{{ $resposta->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <span class="ul-badge {{ $resposta->autor_tipo === 'admin' ? 'ul-badge--azul' : 'ul-badge--sucesso' }}">
                    {{ $resposta->autor_tipo === 'admin' ? 'Admin' : 'Você' }}
                </span>
            </div>
            <p style="margin:0;white-space:pre-wrap;">{{ $resposta->texto }}</p>
        </div>
        @empty
        <div class="ul-painel-card" style="text-align:center;color:#888;">
            <p>Nenhuma resposta ainda.</p>
        </div>
        @endforelse

        {{-- Formulário de Resposta --}}
        <div class="ul-painel-card" style="border:2px solid #10b981;">
            <h3 class="ul-painel-card-titulo">Responder</h3>
            <form action="{{ route('painel.admin-mensagens.responder', $thread->id) }}" method="POST">
                @csrf
                <div class="ul-painel-form-campo">
                    <textarea name="texto" rows="4" class="ul-painel-form-input" placeholder="Escreva a sua resposta..." required minlength="5">{{ old('texto') }}</textarea>
                </div>
                @error('texto')
                <p style="color:#dc3545;font-size:12px;">{{ $message }}</p>
                @enderror
                <button type="submit" class="ul-btn ul-btn--sucesso" style="margin-top:10px;">Enviar Resposta</button>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="ul-painel-card">
            <h3 class="ul-painel-card-titulo">Detalhes</h3>
            <table class="ul-painel-tabela" style="margin:0;">
                <tr><td style="font-weight:bold;">Assunto</td><td>{{ $thread->assunto ?? '—' }}</td></tr>
                <tr><td style="font-weight:bold;">Data</td><td>{{ $thread->created_at->format('d/m/Y H:i') }}</td></tr>
                <tr><td style="font-weight:bold;">Estado</td><td>{{ $thread->lida ? 'Lida' : 'Não lida' }}</td></tr>
                <tr><td style="font-weight:bold;">Respostas</td><td>{{ $thread->respostas->count() }}</td></tr>
            </table>
        </div>
    </div>
</div>
@endsection
