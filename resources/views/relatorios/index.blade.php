
@extends('layout.app')

@section('title', 'Relatórios')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Relatório Geral de Veículos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item active">Relatórios</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <form action="{{ url('relatorios') }}" method="GET">
                                <div class="row align-items-end">
                                    <div class="form-group col-sm-12 col-md-3 mb-2">
                                        <label for="placa">
                                            Placa:
                                        </label>
                                        <input type="text" class="form-control" id="placa" name="placa"
                                            value="{{ old('placa')}}" placeholder="Informe..">
                                    </div>
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
                        <div class="card-body table-responsive p-2">
                            <table id="tabela_itens_relatorio" class="table table-bordered table-hover">
                                <caption></caption>
                                <thead>
                                    <tr>
                                        <th>Placa</th>
                                        <th>Motorista</th>
                                        <th>Produção (R$)</th>
                                        <th>Fretes (qtd)</th>
                                        <th>Transportado (kg)</th>
                                        <th>KM Rodados</th>
                                        <th>Combustível (lts)</th>
                                        <th>Combustível (R$)</th>
                                        <th>Comissão (R$)</th>
                                        <th>Despesas (R$)</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($collection as $item)
                                        <tr>
                                            <td>{{ $item->placa }}</td>
                                            <td>{{ $item->motorista }}</td>
                                            <td>@money($item->valor_producao)</td>
                                            <td>{{ $item->quantidade_fretes }}</td>
                                            <td>@peso($item->peso_transportado)</td>
                                            <td>@km($item->km_rodado)</td>
                                            <td>@litros($item->quantidade_combustivel)</td>
                                            <td>@money($item->valor_combustivel)</td>
                                            <td>@money($item->valor_comissao)</td>
                                            <td>@money($item->valor_despesas)</td>
                                            <td>
                                                <a class="btn btn-primary btn-sm p-1"
                                                    href="{{ url('relatorios/individual', [$item->id]) . '?' . $request->getQueryString() }}">
                                                    <i class="fas fa-edit"> </i> Detalhes
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>Não há dados</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
