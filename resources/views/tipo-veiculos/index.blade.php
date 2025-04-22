
@extends('layout.app')

@section('title', 'Tipos de Veículos')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tipos de Veículos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item active">Tipos de Veículos</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <a href="{{ url('tipo-veiculos/cadastro') }}" class="btn btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Adicionar Tipo de Veículo
                    </a>
                </div>
                <div class="card-body table-responsive p-2">
                    <table id="tipo_veiculos" class="table table-bordered table-hover table-datatable">
                        <caption></caption>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Faz Frete</th>
                                <th>KM - motor</th>
                                <th>KM - caixa</th>
                                <th>KM - diferencial</th>
                                <th>Responsável</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($collection as $item)
                                <tr>
                                    <td>{{ $item->nome }}</td>
                                    <td>{{ $item->fretista }}</td>
                                    <td>@km($item->prox_troca_oleo_motor ?? $prox_troca_oleo_motor)</td>
                                    <td>@km($item->prox_troca_oleo_caixa ?? $prox_troca_oleo_motor)</td>
                                    <td>@km($item->prox_troca_oleo_diferencial ?? $prox_troca_oleo_diferencial)</td>
                                    <td>{{ $item->userTipoIdParaDescricao($item->tipo_usuario_responsavel) }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm p-1"
                                            href="{{ url('tipo-veiculos/cadastro', [$item->id]) }}">
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
