
@extends('layout.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Usuários</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item active">Usuários</li>
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
                            <a href="{{url('usuarios/cadastro')}}" class="btn btn-primary btn-disable"
                                onclick="alert('Esta ação está desabilitada na versão de demonstração'); return false;"> 
                                <i class="fas fa-plus"></i>
                                Adicionar Usuário
                            </a>
                        </div>
                        <div class="card-body">
                            <table id="usuarios" class="table table-bordered table-striped table-datatable">
                                <caption></caption>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Tipo</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($collection as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->nome }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->tipo_usuario }}</td>
                                            <td>
                                                <a class="btn btn-primary btn-sm p-1 btn-disable"
                                                    href="{{ url('usuarios/cadastro', [$item->id]) }}"
                                                    onclick="alert('Esta ação está desabilitada na versão de demonstração'); return false;">
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
                                        </tr>
                                    @endforelse
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
