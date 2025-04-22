
@extends('layout.app')

@section('title', 'Caixas')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Caixas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item active">Caixas</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <a href="{{ url('caixas/cadastro') }}" class="btn btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Adicionar Caixa
                    </a>
                </div>
                <div class="card-body table-responsive p-2">
                    <table id="caixas" class="table table-bordered table-hover table-datatable">
                        <caption></caption>
                        <thead>
                            <tr>
                                <th>Local</th>
                                <th>Saldo</th>
                                <th>Ultima Atualização</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($collection as $item)
                                <tr>
                                    <td>{{ @$item->local->nome }}</td>
                                    <td>@money($item->saldo)</td>
                                    <td>@date($item->data_atualizacao)</td>
                                    <td>
                                        <a class="btn btn-success btn-sm p-1"
                                            href="{{ url('caixas/adicionar', [$item->id]) }}">
                                            <i class="fas fa-plus"> </i> Adicionar
                                        </a>
                                        <a class="btn btn-warning btn-sm p-1"
                                            href="{{ url('caixas/retirar', [$item->id]) }}">
                                            <i class="fas fa-minus"> </i> Retirar
                                        </a>
                                        <a class="btn btn-primary btn-sm p-1"
                                            href="{{ url('caixas/cadastro', [$item->id]) }}">
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
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection
