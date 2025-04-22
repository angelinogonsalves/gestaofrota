
@extends('layout.app')

@section('title', 'Relatórios')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Relatório Individual de Veículos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('relatorios') . '?' . $request->getQueryString() }}">Relatórios</a></li>
                        <li class="breadcrumb-item active">Individual</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            {{-- Filtros --}}
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <form action="{{ url('relatorios/individual', [$item->id]) }}" method="GET">
                        <div class="row align-items-end">
                            <div class="form-group col-sm-12 col-md-3 mb-2">
                                <label for="data_inicio">
                                    Data de Início:
                                </label>
                                <input type="date" class="form-control" id="data_inicio" name="data_inicio"
                                    value="{{ old('data_inicio', $startDate) }}">
                            </div>
                            <div class="form-group col-sm-12 col-md-3 mb-2">
                                <label for="data_fim">
                                    Data de Fim:
                                </label>
                                <input type="date" class="form-control" id="data_fim" name="data_fim"
                                    value="{{ old('data_fim', $endDate) }}">
                            </div>
                            <div class="form-group col-sm-12 col-md-3 mb-2">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                    Pesquisar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Informações gerais do veículo --}}
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Informações</h3>
                </div>
                <div class="card-body table-responsive p-2">
                    <table id="tabela_itens_produto" class="table table-bordered table-hover table-primary">
                        <caption></caption>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Placa</th>
                                <th>KM</th>
                                <th>Data do KM</th>
                                <th>Tipo de Veículo</th>
                                <th>Motorista</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $item->nome }}</td>
                                <td>{{ $item->placa }}</td>
                                <td>@km($item->km_atual)</td>
                                <td>@date($item->km_atualizacao)</td>
                                <td>{{ @$item->tipoVeiculo->nome }}</td>
                                <td>{{ @$item->funcionario->nome }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Fretes do veículo --}}
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Fretes - {{ $item->fretes->first()?->veiculo->placa }} </h3>
                </div>
                <div class="card-body table-responsive p-2">
                    <table id="tabela_itens_produto" class="table table-bordered table-hover table-success">
                        <caption></caption>
                        <thead>
                            <tr><th>Data</th>
                                <th>Local de Origem</th>
                                <th>Local de Destino</th>
                                <th>Empresa</th>
                                <th>Distância (km)</th>
                                <th>Transportado (kg)</th>
                                <th>Valor Tonelada</th>
                                <th>Valor Comissão</th>
                                <th>Valor Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($item->fretes as $frete)
                                <tr>
                                    <td>@date($frete->data_saida)</td>
                                    <td>{{ @$frete->localOrigem->nome }}</td>
                                    <td>{{ @$frete->localDestino->nome }}</td>
                                    <td>{{ @$frete->localEmpresa->nome }}</td>
                                    <td>@km($frete->distancia)</td>
                                    <td>@peso($frete->peso)</td>
                                    <td>@money($frete->valor_tonelada)</td>
                                    <td>@money($frete->comissao)</td>
                                    <td>@money($frete->valor_total)</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="14" class="text-center">Não há dados</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($item->fretes->count())
                            <tfoot>
                                <tr>
                                    <th colspan="1" class="text-center">
                                        TOTAL
                                    </th>
                                    <th colspan="3" class="text-center">
                                        {{ $item->fretes->count() }} frete(s)
                                    </th>
                                    <th colspan="1" class="text-center">
                                        @km($item->fretes->sum('distancia')) km
                                    </th>
                                    <th colspan="1" class="text-center">
                                        @peso($item->fretes->sum('peso')) kg
                                    </th>
                                    <th colspan="1" class="text-center">
                                        @money($item->fretes->sum('valor_tonelada') / $item->fretes->count()) /frete
                                    </th>
                                    <th colspan="1" class="text-center">
                                        @money($item->fretes->sum('comissao'))
                                    </th>
                                    <th colspan="1" class="text-center">
                                        @money($item->fretes->sum('valor_total'))
                                    </th>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
            
            {{-- Despesas do veículo --}}
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Despesas</h3>
                </div>
                <div class="card-body table-responsive p-2">
                    <table id="tabela_itens_produto" class="table table-bordered table-hover table-danger">
                        <caption></caption>
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Tipo de Despesa</th>
                                <th>Descrição</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($item->despesas as $despesa)
                                <tr>
                                    <td>@date($despesa->data)</td>
                                    <td>{{ @$despesa->tipoDespesa->nome }}</td>
                                    <td>{{ $despesa->descricao }}</td>
                                    <td>@money($despesa->valor)</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">Não há dados</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($item->despesas->count())
                            <tfoot>
                                <tr>
                                    <th colspan="1" class="text-center">
                                        Quantidade Total de {{ $item->despesas->count() }} despesa(s)
                                    </th>
                                    <th colspan="1" class="text-center">
                                        Valor Total de @money($item->despesas->sum('valor'))
                                    </th>
                                    <th colspan="2" class="text-center">
                                        Média de @money($item->despesas->sum('valor') / $item->despesas->count()) por despesa
                                    </th>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
            
            {{-- Abastecimentos do veículo --}}
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Abastecimentos</h3>
                </div>
                <div class="card-body table-responsive p-2">
                    <table id="tabela_itens_produto" class="table table-bordered table-hover table-warning">
                        <caption></caption>
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Local de Abastecimento</th>
                                <th>Km abastecimento</th>
                                <th>Km percorrido</th>
                                <th>Litros</th>
                                <th>Média (Km/l)</th>
                                <th>Valor Unitário</th>
                                <th>Valor Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($item->abastecimentos as $abastecimento)
                                <tr>
                                    <td>@date($abastecimento->data)</td>
                                    <td>{{ $abastecimento->local_abastecimento }}</td>
                                    <td>@km($abastecimento->km)</td>
                                    <td>@km($abastecimento->km_percorrido)</td>
                                    <td>@litros($abastecimento->litros)</td>
                                    <td>@litros($abastecimento->media_consumo)</td>
                                    <td>@money($abastecimento->valor_unitario)</td>
                                    <td>@money($abastecimento->valor_total)</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">Não há dados</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($item->abastecimentos->count())
                            <tfoot>
                                <tr>
                                    <th colspan="1" class="text-center">
                                        TOTAL
                                    </th>
                                    <th colspan="2" class="text-center">
                                        {{ $item->abastecimentos->count() }} abastecimento(s)
                                    </th>
                                    <th colspan="1" class="text-center">
                                        @km($item->total_km_percorrido) km
                                    </th>
                                    <th colspan="1" class="text-center">
                                        @litros($item->total_litros) lts
                                    </th>
                                    <th colspan="1" class="text-center">
                                        @km($item->total_media_consumo) km/l
                                    </th>
                                    <th colspan="1" class="text-center">
                                        @money($item->abastecimentos->sum('valor_unitario') / $item->abastecimentos->count())
                                    </th>
                                    <th colspan="1" class="text-center">
                                        @money($item->abastecimentos->sum('valor_total'))
                                    </th>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
            
            {{-- Manutenções do veículo --}}
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Manutenções</h3>
                </div>
                <div class="card-body table-responsive p-2">
                    <table id="tabela_itens_produto" class="table table-bordered table-hover table-info">
                        <caption></caption>
                        <thead>
                            <tr>
                                <th>Data da Solicitação</th>
                                <th>Problema</th>
                                <th>Data de Início</th>
                                <th>Data de Fim</th>
                                <th>Valor Mão de Obra</th>
                                <th>Valor Produtos</th>
                                <th>Valor Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($item->ordemDeServicos as $ordemDeServico)
                                <tr>
                                    <td>@date($ordemDeServico->data_solicitacao)</td>
                                    <td>{{ $ordemDeServico->problema }}</td>
                                    <td>@date($ordemDeServico->data_inicio)</td>
                                    <td>@date($ordemDeServico->data_fim)</td>
                                    <td>@money($ordemDeServico->valor_mao_de_obra)</td>
                                    <td>@money($ordemDeServico->valor_produtos)</td>
                                    <td>@money($ordemDeServico->valor_total)</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">Não há dados</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($item->ordemDeServicos->count())
                            <tfoot>
                                <tr>
                                    <th colspan="2" class="text-center">
                                        Quantidade Total de {{ $item->ordemDeServicos->count() }} manutenção(es)
                                    </th>
                                    <th colspan="2" class="text-center">
                                        Valor Total de @money($item->ordemDeServicos->sum('valor_total'))
                                    </th>
                                    <th colspan="3" class="text-center">
                                        Média de @money($item->ordemDeServicos->sum('valor_total') / $item->ordemDeServicos->count()) por manutenção
                                    </th>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>

        </div>
    </section>
@endsection
