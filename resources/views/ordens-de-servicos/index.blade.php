
@extends('layout.app')

@section('title', 'Ordens de Serviço')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista Ordens de Serviço</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item active">Ordens de Serviço</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <a href="{{ url('ordens-de-servicos/cadastro') }}" class="btn btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Adicionar Ordem de Serviço
                    </a>
                </div>
                <div class="card-body table-responsive p-2">
                    <table id="manutencoes" class="table table-bordered table-hover">
                        <caption></caption>
                        <thead>
                            <tr>
                                <th>Data da Solicitação</th>
                                <th>Veículo</th>
                                <th>Problema</th>
                                <th>Data de início</th>
                                <th>Data de fim</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($collection as $item)
                                <tr>
                                    <td>@date($item->data_solicitacao)</td>
                                    <td>{{ @$item->veiculo->placa }}</td>
                                    <td>{{ $item->problema }}</td>
                                    <td>@date($item->data_inicio)</td>
                                    <td>@date($item->data_fim)</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm p-1"
                                            href="{{ url('ordens-de-servicos/cadastro', [$item->id]) }}">
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
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var manutencoes = $('#manutencoes').DataTable( {
                language:
                    {
                        url: "{{asset('plugins/datatables/datatable-pt-BR.json')}}"
                    },
                dom: 'Bfrtip',
                buttons: [
                    {
                        text: 'Todos',
                        action: function ( e, dt, node, config ) {
                            // Limpa o filtro para mostrar tudo
                            manutencoes.search('').draw();
                        }
                    },
                    {
                        // 5 mês antes
                        text: competenciaAnterior(5)[0],
                        action: function ( e, dt, node, config ) {
                            manutencoes.search(competenciaAnterior(5)[1]).draw();
                        }
                    },
                    {
                        // 4 mês antes
                        text: competenciaAnterior(4)[0],
                        action: function ( e, dt, node, config ) {
                            manutencoes.search(competenciaAnterior(4)[1]).draw();
                        }
                    },
                    {
                        // 3 mês antes
                        text: competenciaAnterior(3)[0],
                        action: function ( e, dt, node, config ) {
                            manutencoes.search(competenciaAnterior(3)[1]).draw();
                        }
                    },
                    {
                        // 2 mês antes
                        text: competenciaAnterior(2)[0],
                        action: function ( e, dt, node, config ) {
                            manutencoes.search(competenciaAnterior(2)[1]).draw();
                        }
                    },
                    {
                        // 1 mês antes
                        text: competenciaAnterior(1)[0],
                        action: function ( e, dt, node, config ) {
                            manutencoes.search(competenciaAnterior(1)[1]).draw();
                        }
                    },
                    {
                        //mês atual
                        text: competenciaAnterior(0)[0],
                        action: function ( e, dt, node, config ) {
                            manutencoes.search(competenciaAnterior(0)[1]).draw();
                        }
                    },
                ],
                // Inicializa a tabela com o filtro para hoje
                initComplete: function () {
                    // Aplica o filtro para mostrar apenas itens com datas do mês atual
                    manutencoes.search(competenciaAnterior(0)[1]).draw()
                },
                stateSave: true,
            } );
        } );
    </script>
@endpush
