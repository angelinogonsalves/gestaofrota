
@extends('layout.app')

@section('title', 'Movimentações')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span>
                        Movimentações
                    </span>
                    <a href="{{ url('movimentacoes/cadastro/entrada') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i>
                        Adicionar Entrada
                    </a>
                    <a href="{{ url('movimentacoes/cadastro/saida') }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-plus"></i>
                        Adicionar Saída
                    </a>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item active">Movimentações</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                
                <div class="card-header">
                    <form action="{{ url('movimentacoes') }}" method="GET">
                        <div class="row align-items-end">
                            <div class="form-group col-sm-12 col-md-2 mb-2">
                                <label for="filtro_conta">
                                    Conta:
                                </label>
                                <input type="text" class="form-control" id="filtro_conta" name="filtro_conta"
                                    value="{{ old('filtro_conta', $request->filtro_conta)}}" placeholder="Informe..">
                            </div>
                            <div class="form-group col-sm-12 col-md-2 mb-2">
                                <label for="filtro_data">
                                    Data
                                </label>
                                <input type="date" name="filtro_data" id="filtro_data" class="form-control"
                                    value="{{ old('filtro_data', $request->filtro_data) }}">
                            </div>
                            <div class="form-group col-sm-12 col-md-3 mb-2">
                                <label for="filtro_competencia">
                                    Competência (data do pagamento):
                                </label>
                                <select name="filtro_competencia" id="filtro_competencia" class="form-control">
                                    <option value="-1">--</option>
                                    @foreach ($competences as $competence => $competenceName)
                                        <option value="{{ $competence }}"
                                            @if (old('filtro_competencia', $request->filtro_competencia) == $competence)
                                                selected=""
                                            @endif >
                                            {{ $competenceName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-12 col-md-2 mb-2">
                                <label for="filtro_movimentacao">
                                    Tipo de Movimentação:
                                </label>
                                <select name="filtro_movimentacao" id="filtro_movimentacao" class="form-control">
                                    <option value="-1">--</option>
                                    @foreach ($movimentacoes as $tipo_de_movimentacao => $nome_movimentacao)
                                        <option value="{{ $tipo_de_movimentacao }}"
                                            @if (old('filtro_movimentacao', $request->filtro_movimentacao) == $tipo_de_movimentacao)
                                                selected=""
                                            @endif >
                                            {{ $nome_movimentacao }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-12 col-md-2 mb-2">
                                <button class="btn btn-info" type="submit">
                                    <i class="fas fa-search"></i>
                                    Pesquisar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body table-responsive p-2">
                    <table id="movimentacoes" class="table table-bordered table-hover">
                        <caption></caption>
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Tipo de Movimentação</th>
                                <th>Conta</th>
                                <th>Origem / Destino</th>
                                <th>Valor</th>
                                <th>Motivo</th>
                                <th>Tipo de Pagamento</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($collection as $item)
                                <tr>
                                    <td>@date($item->pagamento)</td>
                                    <td>{{ $item->tipo_de_movimentacao_descrita }}</td>
                                    <td>{{ $item->conta }}</td>
                                    <td>{{ $item->origem_destino }}</td>
                                    <td>@money($item->valor)</td>
                                    <td>{{ $item->motivo }}</td>
                                    <td>{{ $item->tipo_pagamento }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm p-1"
                                            href="{{ url('movimentacoes/cadastro', [$item->id]) . '?' . $request->getQueryString() }}">
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
                        <tfoot>
                            <tr class="d-none">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><strong>Total:</strong></td>
                                <td id="sum-value"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#movimentacoes').DataTable( {
                language:
                    {
                        url: "{{asset('plugins/datatables/datatable-pt-BR.json')}}"
                    },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Exportar para Excel',
                        className: 'bg-success',
                        footer: true,
                        exportOptions: {
                            // Inclui todas as colunas, inclusive a nova oculta
                            columns: function (idx, data, node) {
                                return true;
                            }
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'Exportar para PDF',
                        className: 'bg-danger',
                        footer: true,
                        exportOptions: {
                            // Inclui todas as colunas, inclusive a nova oculta
                            columns: function (idx, data, node) {
                                return true;
                            }
                        }
                    }
                ],
                stateSave: true,
                footerCallback: function (row, data, start, end, display) {
                    var api = this.api();

                    // Função para remover o formato e converter para número
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            Number(i.replace(/[^\d,-]/g, '').replace(',', '.')) :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Soma total de todas as páginas filtradas
                    var total = api
                        .column(4, { search: 'applied' }) // Calcula com base em todas as páginas filtradas
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Soma total da página atualmente visível
                    var pageTotal = api
                        .column(4, { page: 'current' })
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Atualiza o footer com o valor somado de todas as páginas filtradas
                    $(api.column(4).footer()).html(
                        new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(total)
                    );

                    // Se necessário, você pode usar o `pageTotal` para atualizar outros elementos na tela
                }
            } );    
        } );
    </script>
@endpush
