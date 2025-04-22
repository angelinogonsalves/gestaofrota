
@extends('layout.app')

@section('title', 'Produtos')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Produtos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item active">Produtos</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <a href="{{ url('produtos/cadastro') }}" class="btn btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Adicionar produto
                    </a>
                    <a href="{{ url('produtos/adicionar') }}" class="btn btn btn-success">
                        <i class="fas fa-plus"></i>
                        Adicionar Estoque
                    </a>
                    <a href="{{ url('produtos/retirar') }}" class="btn btn btn-warning">
                        <i class="fas fa-minus"></i>
                        Retirar Estoque
                    </a>
                </div>
                <div class="card-body table-responsive p-2">
                    <table id="produtos" class="table table-bordered table-hover table-datatable">
                        <caption></caption>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Código de Barras</th>
                                <th>Valor Unitário</th>
                                <th>Valor Total</th>
                                <th>Unidade de medida</th>
                                <th>Quantidade em estoque</th>
                                <th>Ultima Atualização</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($collection as $item)
                                <tr>
                                    <td>{{ $item->nome }}</td>
                                    <td>{{ $item->codigo_de_barras }}</td>
                                    <td>@money($item->valor_unitario)</td>
                                    <td>@money($item->valor_total)</td>
                                    <td>{{ $item->unidade_de_medida }}</td>
                                    <td>@litros($item->quantidade_em_estoque)</td>
                                    <td>@date($item->data_atualizacao)</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm p-1"
                                            href="{{ url('produtos/cadastro', [$item->id]) }}">
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
