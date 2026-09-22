@extends('layouts.painel')

@section('title', 'Visitas — Painel')

@section('content')
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo">Visitas</h1>
</div>

<div class="ul-painel-stats" style="margin-bottom:20px;">
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero">{{ $estatisticas['hoje'] }}</span>
        <span class="ul-painel-stat-rotulo">Hoje</span>
    </div>
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero">{{ $estatisticas['pendente'] }}</span>
        <span class="ul-painel-stat-rotulo">Pendentes</span>
    </div>
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero">{{ $estatisticas['confirmada'] }}</span>
        <span class="ul-painel-stat-rotulo">Confirmadas</span>
    </div>
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero">{{ $estatisticas['concluida'] ?? 0 }}</span>
        <span class="ul-painel-stat-rotulo">Concluídas</span>
    </div>
</div>

<div class="ul-painel-tabela-wrap">
    <table class="ul-painel-tabela">
        <thead>
            <tr>
                <th>Imóvel</th>
                <th>Cliente</th>
                <th>Contacto</th>
                <th>Data/Hora</th>
                <th>Estado</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($visitas as $visita)
            <tr>
                <td data-label="Imóvel">{{ $visita->imovel->titulo ?? '—' }}</td>
                <td data-label="Cliente">{{ $visita->cliente_nome }}</td>
                <td data-label="Contacto">
                    @if($visita->cliente_email && str_contains($visita->cliente_email, '@'))
                        <a href="mailto:{{ $visita->cliente_email }}" style="color:var(--ul-blue);text-decoration:none;">{{ $visita->cliente_email }}</a>
                    @elseif($visita->cliente_telefone)
                        <a href="tel:{{ $visita->cliente_telefone }}" style="color:var(--ul-blue);text-decoration:none;">{{ $visita->cliente_telefone }}</a>
                    @else
                        —
                    @endif
                </td>
                <td data-label="Data/Hora">{{ $visita->data_visita->format('d/m/Y H:i') }}</td>
                <td data-label="Estado">
                    @if($visita->estado === 'pendente')
                        <span class="ul-badge ul-badge--pendente">Pendente</span>
                    @elseif($visita->estado === 'confirmada')
                        <span class="ul-badge ul-badge--aprovado">Confirmada</span>
                    @elseif($visita->estado === 'concluida')
                        <span class="ul-badge ul-badge--aviso">Concluída</span>
                    @else
                        <span class="ul-badge ul-badge--rejeitado">Cancelada</span>
                    @endif
                </td>
                <td data-label="Ações">
                    <div style="display:flex;gap:6px;flex-wrap:wrap;">
                        @if($visita->estado === 'pendente')
                            <form action="{{ route('painel.visitas.estado', $visita) }}" method="POST">
                                @csrf
                                <input type="hidden" name="estado" value="confirmada">
                                <button type="submit" class="ul-painel-btn ul-painel-btn--pequeno" style="color:#10b981;" title="Aceitar"><i class="bi bi-check-lg"></i> Aceitar</button>
                            </form>
                            <button type="button" class="ul-painel-btn ul-painel-btn--perigo ul-painel-btn--pequeno" title="Recusar" onclick="abrirMotivo({{ $visita->id }})"><i class="bi bi-x-lg"></i> Recusar</button>
                        @elseif($visita->estado === 'confirmada')
                            <form action="{{ route('painel.visitas.estado', $visita) }}" method="POST">
                                @csrf
                                <input type="hidden" name="estado" value="concluida">
                                <button type="submit" class="ul-painel-btn ul-painel-btn--pequeno" style="color:#1a5276;" title="Concluir"><i class="bi bi-check-lg"></i> Concluir</button>
                            </form>
                            <button type="button" class="ul-painel-btn ul-painel-btn--perigo ul-painel-btn--pequeno" title="Cancelar" onclick="abrirMotivo({{ $visita->id }})"><i class="bi bi-x-lg"></i> Cancelar</button>
                        @else
                            <span style="font-size:12px;color:var(--ul-gray2);">—</span>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="ul-painel-vazio">Nenhuma visita encontrada.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $visitas->withQueryString()->links() }}

<div id="motivoModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:10px;padding:30px;max-width:450px;width:90%;box-shadow:0 10px 30px rgba(0,0,0,0.3);">
        <h3 style="margin:0 0 10px;">Motivo da Recusa/Cancelamento</h3>
        <form id="motivoForm" method="POST">
            @csrf
            <input type="hidden" name="estado" value="cancelada">
            <textarea name="motivo" rows="3" class="ul-input" placeholder="Ex: Imóvel já alugado, dia indisponível..." required></textarea>
            <div style="display:flex;gap:8px;margin-top:15px;justify-content:flex-end;">
                <button type="button" class="ul-painel-btn" onclick="fecharMotivo()">Cancelar</button>
                <button type="submit" class="ul-painel-btn ul-painel-btn--perigo">Confirmar</button>
            </div>
        </form>
    </div>
</div>

<script>
function abrirMotivo(id) {
    document.getElementById('motivoForm').action = '/painel/visitas/' + id + '/estado';
    document.getElementById('motivoModal').style.display = 'flex';
}
function fecharMotivo() {
    document.getElementById('motivoModal').style.display = 'none';
}
</script>
@endsection
