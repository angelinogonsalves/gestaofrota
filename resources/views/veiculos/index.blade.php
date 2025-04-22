
@extends('layout.app')

@section('title', 'Veículos')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Veículos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item active">Veículos</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <a href="{{ url('veiculos/cadastro') }}" class="btn btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Adicionar Veículo
                    </a>
                </div>
                <div class="card-body table-responsive p-2">
                    <table id="veiculos" class="table table-bordered table-hover table-datatable">
                        <caption></caption>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Placa</th>
                                <th>KM</th>
                                <th>Data do KM</th>
                                <th>Tipo de Veículo</th>
                                <th>Motorista</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($collection as $item)
                                <tr>
                                    <td>{{ $item->nome }}</td>
                                    <td>{{ $item->placa }}</td>
                                    <td>@km($item->km_atual)</td>
                                    <td>@date($item->km_atualizacao)</td>
                                    <td>{{ @$item->tipoVeiculo->nome }}</td>
                                    <td>{{ @$item->funcionario->nome }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm p-1"
                                            href="{{ url('veiculos/cadastro', [$item->id]) }}">
                                            <i class="fas fa-edit"> </i> Editar
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
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection
