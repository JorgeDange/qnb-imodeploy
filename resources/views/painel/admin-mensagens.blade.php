@extends('layouts.painel')

@section('title', 'Mensagens do Admin — Painel | QNB-Imobiliária')

@section('content')
<div class="ul-painel-head">
    <div>
        <h3 class="ul-painel-card-titulo ul-mb-4">Mensagens do Administrador</h3>
        <p class="ul-painel-card-subtitulo ul-mb-0">{{ $threads->count() }} conversa(s) no total.</p>
    </div>
</div>

@if(session('sucesso'))
<div class="ul-alert ul-alert--sucesso">{{ session('sucesso') }}</div>
@endif

@if($threads->count())
<div class="ul-painel-card">
    <div style="overflow-x:auto;">
        <table class="ul-painel-tabela">
            <thead>
                <tr>
                    <th>Estado</th>
                    <th>Assunto</th>
                    <th>De</th>
                    <th>Data</th>
                    <th>Respostas</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($threads as $thread)
                <tr style="{{ !$thread->lida ? 'background:#f0fdf4;' : '' }}">
                    <td>
                        @if(!$thread->lida)
                            <span class="ul-badge ul-badge--aviso">Não lida</span>
                        @else
                            <span class="ul-badge ul-badge--cinza">Lida</span>
                        @endif
                    </td>
                    <td><strong>{{ $thread->assunto ?? 'Sem assunto' }}</strong></td>
                    <td>{{ $thread->admin->name ?? 'Admin' }}</td>
                    <td>{{ $thread->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $thread->respostas->count() }}</td>
                    <td>
                        <a href="{{ route('painel.admin-mensagens.show', $thread->id) }}" class="ul-btn ul-btn--sm ul-btn--azul">Ver</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div class="ul-painel-card">
    <div class="ul-painel-vazio">
        <i class="bi bi-envelope" style="font-size:48px;color:#ccc;margin-bottom:15px;display:block;"></i>
        <p>Nenhuma mensagem do administrador.</p>
    </div>
</div>
@endif
@endsection
