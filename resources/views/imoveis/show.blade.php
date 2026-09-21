@extends('layouts.site')

@section('title', $imovel->titulo . ' - QNB-Imobiliária')
@section('pagina', 'detalhe')
@section('header-class', 'ul-header')

@section('content')
<!-- BREADCRUMB SECTION START -->
<div class="ul-breadcrumb">
    <div class="wow animate__fadeInUp">
        <h2 class="ul-breadcrumb-title">Detalhe do Imóvel</h2>
        <div class="ul-breadcrumb-nav">
            <a href="{{ route('home') }}">Início</a>
            <span class="separator"><i class="flaticon-aro-left"></i></span>
            <a href="{{ route('imoveis.index') }}">Imóveis</a>
            <span class="separator"><i class="flaticon-aro-left"></i></span>
            <span class="current-page">{{ $imovel->titulo }}</span>
        </div>
    </div>
</div>
<!-- BREADCRUMB SECTION END -->

<div class="ul-inner-page-content-wrapper">
    <div class="ul-inner-page-container">
        <!-- heading -->
        <div class="ul-project-details-heading">
            <div class="left">
                <h3 class="ul-project-details-title">{{ $imovel->titulo }}</h3>
                <span class="ul-project-details-location"><span class="icon"><i class="flaticon-maps-and-flags"></i></span>{{ $imovel->municipio }}, {{ $imovel->provincia }}</span>
                @if($imovel->media_estrelas)
                <span style="display:inline-flex;align-items:center;gap:4px;margin-left:12px;padding:4px 10px;background:#f0f7ff;border-radius:20px;font-size:13px;color:#1a5276;font-weight:600;">
                    <i class="flaticon-star" style="color:#f4c430;font-size:14px;"></i>
                    {{ $imovel->media_estrelas }}
                    <span style="font-weight:400;color:#666;">({{ $imovel->avaliacoes_count }})</span>
                </span>
                @endif
            </div>

            <div class="right">
                <div class="ul-project-details-actions">
                    @auth('cliente')
                    <form action="{{ route('cliente.favoritos.store', $imovel->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="ul-project-details-action">
                            <span class="icon"><i class="flaticon-heart"></i></span>
                            <span>Guardar</span>
                        </button>
                    </form>
                    @else
                    <a href="{{ route('cliente.login') }}" class="ul-project-details-action">
                        <span class="icon"><i class="flaticon-heart"></i></span>
                        <span>Guardar</span>
                    </a>
                    @endauth
                    <button class="ul-project-details-action" type="button" onclick="partilharLink(this)">
                        <span class="icon"><i class="flaticon-share-1"></i></span>
                        <span>Partilhar</span>
                    </button>
                </div>

                <div class="ul-project-details-price"><span class="number">{{ number_format($imovel->preco, 0, ',', '.') }}</span> {{ $imovel->moeda }}</div>
            </div>
        </div>

        <!-- body -->
        <div class="ul-project-details-body">
            <div class="row gy-5">
                <!-- left -->
                <div class="col-lg-8">
                    <!-- img slider -->
                    <div class="ul-project-details-slider-wrapper wow animate__fadeInUp">
                        <div class="swiper ul-project-details-img-slider">
                            <div class="swiper-wrapper">
                                @foreach($imovel->fotos->sortBy('ordem') as $foto)
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/' . $foto->caminho) }}" alt="{{ $imovel->titulo }}">
                                </div>
                                @endforeach
                                @if($imovel->fotos->isEmpty())
                                <div class="swiper-slide">
                                    <img src="{{ asset('assets/img/project-details-img-big-1.jpg') }}" alt="{{ $imovel->titulo }}">
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="swiper ul-project-details-img-slider-thumb">
                            <div class="swiper-wrapper">
                                @foreach($imovel->fotos->sortBy('ordem') as $foto)
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/' . $foto->caminho) }}" alt="{{ $imovel->titulo }}">
                                </div>
                                @endforeach
                                @if($imovel->fotos->isEmpty())
                                <div class="swiper-slide">
                                    <img src="{{ asset('assets/img/project-details-img-big-1.jpg') }}" alt="{{ $imovel->titulo }}">
                                </div>
                                @endif
                            </div>

                            <!-- navigation -->
                            <div class="ul-slider-nav ul-project-details-img-slider-thumb-nav">
                                <button class="prev"><i class="flaticon-arrow"></i></button>
                                <button class="next"><i class="flaticon-right-arrow"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- description -->
                    <div class="ul-project-details-block wow animate__fadeIn">
                        <h3 class="ul-project-details-title">Descrição</h3>
                        {!! $imovel->descricao !!}
                    </div>

                    <!-- overview -->
                    <div class="ul-project-details-block wow animate__fadeIn">
                        <h3 class="ul-project-details-title">Visão Geral</h3>
                        <div class="ul-project-details-overview-infos wow animate__fadeInUp">
                            <div class="row row-cols-xl-5 row-cols-sm-4 row-cols-3 row-cols-xxs-2 ul-bs-row">
                                <div class="col">
                                    <div class="ul-project-details-overview-info">
                                        <div class="icon"><i class="flaticon-buildings"></i></div>
                                        <div class="txt">
                                            <span class="key">Nº de Referência</span>
                                            <span class="value">#{{ $imovel->referencia }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="ul-project-details-overview-info">
                                        <div class="icon"><i class="flaticon-home-tik-mark"></i></div>
                                        <div class="txt">
                                            <span class="key">Tipo</span>
                                            <span class="value">{{ ucfirst($imovel->tipologia) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="ul-project-details-overview-info">
                                        <div class="icon"><i class="flaticon-bed-color"></i></div>
                                        <div class="txt">
                                            <span class="key">Quartos</span>
                                            <span class="value">{{ $imovel->dormitorios }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="ul-project-details-overview-info">
                                        <div class="icon"><i class="flaticon-bath"></i></div>
                                        <div class="txt">
                                            <span class="key">Casas de Banho</span>
                                            <span class="value">{{ $imovel->banheiros }}</span>
                                        </div>
                                    </div>
                                </div>

                                @if($imovel->area_construida)
                                <div class="col">
                                    <div class="ul-project-details-overview-info">
                                        <div class="icon"><i class="flaticon-buildings"></i></div>
                                        <div class="txt">
                                            <span class="key">Área (m²)</span>
                                            <span class="value">{{ number_format($imovel->area_construida, 0) }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="col">
                                    <div class="ul-project-details-overview-info">
                                        <div class="icon"><i class="flaticon-house-1"></i></div>
                                        <div class="txt">
                                            <span class="key">Estado</span>
                                            <span class="value">{{ ucfirst($imovel->estado_imovel) }}</span>
                                        </div>
                                    </div>
                                </div>

                                @if($imovel->estacionamento)
                                <div class="col">
                                    <div class="ul-project-details-overview-info">
                                        <div class="icon"><i class="flaticon-parking"></i></div>
                                        <div class="txt">
                                            <span class="key">Estacionamento</span>
                                            <span class="value">{{ $imovel->estacionamento }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($imovel->ano_construcao)
                                <div class="col">
                                    <div class="ul-project-details-overview-info">
                                        <div class="icon"><i class="flaticon-tools"></i></div>
                                        <div class="txt">
                                            <span class="key">Ano de Construção</span>
                                            <span class="value">{{ $imovel->ano_construcao }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Features & amenities -->
                    @if($imovel->amenidades->count())
                    <div class="ul-project-details-block wow animate__fadeIn">
                        <h3 class="ul-project-details-title">Características e Comodidades</h3>
                        <div class="ul-project-details-features wow animate__fadeInUp">
                            @foreach($imovel->amenidades as $amenidade)
                            <span class="feature"><span class="icon"><i class="flaticon-check-4"></i></span><span class="txt">{{ $amenidade->nome }}</span></span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Avaliações aprovadas -->
                    @php $avaliacoesAprovadas = $imovel->avaliacoes()->where('estado', 'aprovada')->with('cliente')->latest()->get(); @endphp
                    @if($avaliacoesAprovadas->count())
                    <div class="ul-project-details-block wow animate__fadeIn">
                        <h3 class="ul-project-details-title">
                            Avaliações
                            <span style="font-size:14px;font-weight:400;color:#666;margin-left:8px;">
                                <i class="flaticon-star" style="color:#f4c430;"></i> {{ $imovel->media_estrelas }} ({{ $imovel->avaliacoes_count }})
                            </span>
                        </h3>
                        <div class="avaliacoes-lista mt-3">
                            @foreach($avaliacoesAprovadas as $avaliacao)
                            <div style="padding:14px 0;border-bottom:1px solid #f0f0f0;">
                                <div style="display:flex;justify-content:space-between;align-items:center;">
                                    <div>
                                        <strong style="color:#333;">{{ $avaliacao->autor_nome }}</strong>
                                        <span style="margin-left:8px;color:#888;font-size:12px;">{{ $avaliacao->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <div style="color:#f4c430;font-size:13px;">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $avaliacao->estrelas)★@else☆@endif
                                        @endfor
                                    </div>
                                </div>
                                @if($avaliacao->comentario)
                                <p style="margin:6px 0 0;color:#555;font-size:14px;">{{ $avaliacao->comentario }}</p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- location -->
                    @if($imovel->latitude && $imovel->longitude)
                    <div class="ul-project-details-block wow animate__fadeIn">
                        <h3 class="ul-project-details-title">Localização</h3>
                        <div class="ul-project-details-map wow animate__fadeInUp">
                            <iframe src="https://www.google.com/maps?q={{ $imovel->latitude }},{{ $imovel->longitude }}&output=embed" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                    @endif

                </div>

                <!-- right sidebar -->
                <div class="col-lg-4">
                    <div class="ul-project-details-sidebar wow animate__fadeInUp">
                        <h3 class="ul-project-details-sidebar-title">Contacte a Imobiliária Responsável</h3>

                        <div class="ul-project-details-listing-owner">
                            <div class="ul-project-details-listing-owner-img">
                                @php $imob = $imovel->imobiliaria; @endphp
                                @if($imob && $imob->foto)
                                    <img src="{{ str_starts_with($imob->foto, 'assets/') ? asset($imob->foto) : asset('storage/' . $imob->foto) }}" alt="{{ $imob->nome }}">
                                @else
                                    <img src="{{ asset('assets/img/logo-c.svg') }}" alt="{{ $imob->nome ?? 'QNB' }}">
                                @endif
                            </div>
                            <div class="ul-project-details-listing-owner-txt">
                                <h4 class="ul-project-details-listing-owner-name">{{ $imovel->imobiliaria->nome ?? 'QNB-Imobiliária' }}</h4>
                                <span class="contact-infos d-block">Imobiliária Parceira</span>

                                @auth('cliente')
                                <div class="contact-infos">
                                    <a href="tel:{{ $imovel->imobiliaria->telefone ?? '+244921852727' }}"><i class="flaticon-telephone"></i> {{ $imovel->imobiliaria->telefone ?? '+244 921 852 727' }}</a>
                                    <a href="mailto:{{ $imovel->imobiliaria->email ?? 'comercial@qnbangola.com' }}"><i class="flaticon-email"></i> {{ $imovel->imobiliaria->email ?? 'comercial@qnbangola.com' }}</a>
                                </div>
                                @else
                                <div class="contact-infos" style="margin-top:8px;">
                                    <p style="font-size:13px;color:var(--ul-gray2);margin-bottom:8px;">Faça login para ver o contacto completo.</p>
                                </div>
                                @endauth
                            </div>
                        </div>

                        @auth('cliente')
                        <!-- Botão Agendar Visita -->
                        <button type="button" class="ul-btn w-100" style="background:#1a5276;margin-bottom:12px;" onclick="abrirAgendamento({{ $imovel->id }})">
                            <i class="flaticon-calendar"></i> Agendar Visita
                        </button>

                        <!-- Formulário de mensagem — cliente autenticado -->
                        <form action="{{ route('cliente.mensagens.enviar', $imovel->id) }}" method="POST" class="ul-project-details-owner-contact-form">
                            @csrf
                            <div class="form-group">
                                <textarea name="texto" rows="4" placeholder="Escreva a sua mensagem..." required></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="ul-btn w-100">Enviar Mensagem</button>
                            </div>
                        </form>
                        @else
                        <!-- CTA — visitante não autenticado -->
                        <div style="text-align:center;padding:20px 0;">
                            <p style="font-size:14px;color:var(--ul-gray2);margin-bottom:16px;">Inicie sessão para enviar mensagem e ver o contacto completo.</p>
                            <div style="display:flex;flex-direction:column;gap:10px;">
                                <a href="{{ route('cliente.login') }}" class="ul-btn w-100">Entrar</a>
                                <a href="{{ route('cliente.registo') }}" class="ul-btn ul-btn--outline w-100">Criar Conta</a>
                            </div>
                        </div>
                        @endauth

                        @if($imovel->canais->where('tipo', 'whatsapp')->count())
                        <a href="https://wa.me/{{ $imovel->canais->where('tipo', 'whatsapp')->first()->valor }}" class="ul-btn ul-project-details-wa-btn" target="_blank"><i class="flaticon-telephone"></i> Falar no WhatsApp</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Agendamento de Visita -->
<div id="modalAgendamento" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:12px;padding:30px;max-width:500px;width:90%;max-height:90vh;overflow-y:auto;box-shadow:0 10px 30px rgba(0,0,0,0.3);">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h3 style="margin:0;">Agendar Visita</h3>
            <button type="button" onclick="fecharAgendamento()" style="background:none;border:none;font-size:24px;cursor:pointer;color:#888;">&times;</button>
        </div>

        <form id="agendamentoForm" action="{{ route('cliente.visitas.store', $imovel->id) }}" method="POST">
            @csrf
            <input type="hidden" name="data_visita" id="agendamentoData" value="">

            <div id="calendarioContainer"></div>
            <div id="horariosContainer"></div>

            <div style="margin-top:20px;display:flex;gap:10px;justify-content:flex-end;">
                <button type="button" class="ul-btn ul-btn--outline" onclick="fecharAgendamento()">Cancelar</button>
                <button type="button" class="ul-btn" style="background:#1a5276;" onclick="submeterAgendamento()">Confirmar Agendamento</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function partilharLink(btn) {
    var url = window.location.href;
    var texto = btn.querySelector('span:last-child');

    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(url).then(function() {
            texto.textContent = 'Copiado!';
            setTimeout(function() { texto.textContent = 'Partilhar'; }, 2000);
        }).catch(function() {
            fallbackCopy(url, texto);
        });
    } else {
        fallbackCopy(url, texto);
    }
}

function fallbackCopy(text, label) {
    var tmp = document.createElement('input');
    tmp.value = text;
    document.body.appendChild(tmp);
    tmp.select();
    document.execCommand('copy');
    document.body.removeChild(tmp);
    label.textContent = 'Copiado!';
    setTimeout(function() { label.textContent = 'Partilhar'; }, 2000);
}

// ===== AGENDAMENTO DE VISITAS =====
var imovelIdGlobal = null;
var diasIndisponiveis = [];
var horariosDisponiveis = [];
var dataSelecionada = null;

function abrirAgendamento(imovelId) {
    imovelIdGlobal = imovelId;
    dataSelecionada = null;

    fetch('/cliente/imoveis/' + imovelId + '/dias-disponiveis')
        .then(function(r) { return r.json(); })
        .then(function(data) {
            diasIndisponiveis = data.dias_indisponiveis || [];
            horariosDisponiveis = data.horarios || [];
            renderizarCalendario();
            document.getElementById('modalAgendamento').style.display = 'flex';
        })
        .catch(function() {
            modalErro('Erro', 'Ocorreu um erro ao carregar a disponibilidade. Tente novamente.');
        });
}

function fecharAgendamento() {
    document.getElementById('modalAgendamento').style.display = 'none';
}

function renderizarCalendario() {
    var hoje = new Date();
    var ano = hoje.getFullYear();
    var mes = hoje.getMonth();
    var primeiroDia = new Date(ano, mes, 1).getDay();
    var diasNoMes = new Date(ano, mes + 1, 0).getDate();
    var nomesMes = ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];

    var html = '<div class="cal-header"><button type="button" onclick="mesAnterior()">&laquo;</button>';
    html += '<span id="calMesAno">' + nomesMes[mes] + ' ' + ano + '</span>';
    html += '<button type="button" onclick="mesProximo()">&raquo;</button></div>';
    html += '<table class="cal-tabela"><thead><tr>';
    var diasSemana = ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb'];
    for (var d = 0; d < 7; d++) html += '<th>' + diasSemana[d] + '</th>';
    html += '</tr></thead><tbody><tr>';

    for (var i = 0; i < primeiroDia; i++) html += '<td></td>';

    for (var dia = 1; dia <= diasNoMes; dia++) {
        var dataStr = ano + '-' + String(mes + 1).padStart(2, '0') + '-' + String(dia).padStart(2, '0');
        var dataObj = new Date(ano, mes, dia);
        var hojeInicio = new Date(hoje.getFullYear(), hoje.getMonth(), hoje.getDate());

        var indisponivel = diasIndisponiveis.indexOf(dataStr) !== -1;
        var passado = dataObj < hojeInicio;
        var fimSemana = dataObj.getDay() === 0;
        var desabilitado = indisponivel || passado || fimSemana;

        var cls = desabilitado ? 'cal-dia cal-dia--desabilitado' : 'cal-dia cal-dia--disponivel';
        var onclick = desabilitado ? '' : ' onclick="selecionarDia(\'' + dataStr + '\', this)"';

        html += '<td class="' + cls + '"' + onclick + '>' + dia + '</td>';

        if ((primeiroDia + dia) % 7 === 0 && dia < diasNoMes) html += '</tr><tr>';
    }

    html += '</tr></tbody></table>';
    document.getElementById('calendarioContainer').innerHTML = html;
}

function selecionarDia(dataStr, el) {
    document.querySelectorAll('.cal-dia--selecionado').forEach(function(e) { e.classList.remove('cal-dia--selecionado'); });
    el.classList.add('cal-dia--selecionado');
    dataSelecionada = dataStr;

    var horariosHtml = '';
    horariosDisponiveis.forEach(function(h) {
        horariosHtml += '<label class="cal-horario"><input type="radio" name="hora" value="' + h + '"> ' + h + '</label>';
    });
    document.getElementById('horariosContainer').innerHTML = horariosHtml || '<p style="color:#999;">Nenhum horário disponível.</p>';
    document.getElementById('horariosContainer').style.display = 'block';
}

function submeterAgendamento() {
    var hora = document.querySelector('input[name="hora"]:checked');
    if (!dataSelecionada || !hora) {
        modalErro('Aviso', 'Selecione um dia e um horário antes de confirmar.');
        return;
    }

    var form = document.getElementById('agendamentoForm');
    document.getElementById('agendamentoData').value = dataSelecionada + ' ' + hora.value + ':00';
    form.submit();
}

function mesAnterior() { /* simplificado: recarrega */ renderizarCalendario(); }
function mesProximo() { /* simplificado: recarrega */ renderizarCalendario(); }
</script>

<style>
.cal-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; font-weight:600; }
.cal-header button { background:none; border:1px solid #ddd; border-radius:4px; padding:4px 10px; cursor:pointer; font-size:16px; }
.cal-tabela { width:100%; border-collapse:collapse; text-align:center; }
.cal-tabela th { font-size:12px; color:#888; padding:6px 0; }
.cal-dia { padding:8px 4px; cursor:pointer; border-radius:4px; font-size:14px; }
.cal-dia--disponivel:hover { background:#e8f4fd; color:#1a5276; }
.cal-dia--selecionado { background:#1a5276 !important; color:#fff !important; }
.cal-dia--desabilitado { color:#ccc; cursor:default; }
.cal-horario { display:inline-block; margin:4px; }
.cal-horario input { margin-right:4px; }
#horariosContainer { margin-top:15px; display:none; }
</style>
@endpush
@endsection
