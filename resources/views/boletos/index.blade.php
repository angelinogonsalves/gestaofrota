
@extends('layout.app')

@section('title', 'Boletos')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span>
                        Boletos
                    </span>
                    <a href="{{ url('boletos/cadastro') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i>
                        Adicionar
                    </a>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item active">Boletos</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">

                <div class="card-header">
                    <form action="{{ url('boletos') }}" method="GET">
                        <div class="row align-items-end">
                            <div class="form-group col-sm-12 col-md-3 mb-2">
                                <label for="filtro_placa">
                                    Placa:
                                </label>
                                <input type="text" class="form-control" id="filtro_placa" name="filtro_placa"
                                    value="{{ old('filtro_placa', $request->filtro_placa)}}" placeholder="Informe..">
                            </div>
                            <div class="form-group col-sm-12 col-md-3 mb-2">
                                <label for="filtro_competencia">
                                    Competência:
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
                            <div class="form-group col-sm-12 col-md-3 mb-2">
                                <label for="filtro_situacao">
                                    Situação:
                                </label>
                                <select name="filtro_situacao" id="filtro_situacao" class="form-control">
                                    <option value=""
                                        @if (old('filtro_situacao', $request->filtro_situacao) == $competence)
                                            selected=""
                                        @endif >
                                        --
                                    </option>
                                    <option value="AGUARDANDO PAGAMENTO"
                                        @if (old('filtro_situacao', $request->filtro_situacao) == 'AGUARDANDO PAGAMENTO')
                                            selected=""
                                        @endif >
                                        AGUARDANDO PAGAMENTO
                                    </option>
                                    <option value="PAGO"
                                        @if (old('filtro_situacao', $request->filtro_situacao) == 'PAGO')
                                            selected=""
                                        @endif >
                                        PAGO
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-sm-12 col-md-3 mb-2">
                                <button class="btn btn-info" type="submit">
                                    <i class="fas fa-search"></i>
                                    Pesquisar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body table-responsive p-2">
                    <table id="boletos" class="table table-bordered table-hover">
                        <caption></caption>
                        <thead>
                            <tr>
                                <th>Vencimento</th>
                                <th>Boleto</th>
                                <th>Parcela</th>
                                <th>Valor</th>
                                <th>Descrição</th>
                                <th>Pagamento</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($collection as $item)
                                <tr>
                                    <td>@date($item->vencimento)</td>
                                    <td>{{ $item->boleto }}</td>
                                    <td>{{ $item->parcela }}</td>
                                    <td>@money($item->valor)</td>
                                    <td>{{ $item->descricao }}</td>
                                    <td>
                                        <span class="badge badge-{{ $item->classeStatusPagamento }}">
                                            {{ $item->statusPagamento }}
                                        </span>
                                    </td>
                                    <td class="d-flex">
                                        <div class="p-1">
                                            <a class="btn btn-sm btn-primary" href="{{ url('boletos/cadastro', [$item->id]) }}">
                                                <i class="fas fa-edit"> </i> Editar
                                            </a>
                                        </div>
                                        @if (!$item->pago)
                                            <form class="p-1" action="{{ url('boletos/pagar', [$item->id]) }}" method="post"
                                                onsubmit="return confirm('Tem certeza de que deseja mudar o boleto para PAGO?');">
                                                @csrf
                                                <input type="hidden" name="pago" value="1">
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class='fas fa-check'> </i> Mudar para Pago
                                                </button>
                                            </form>
                                        @endif
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
                        <tfoot>
                            <tr class="">
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
            var boletos = $('#boletos').DataTable( {
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
                        footer: true
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'Exportar para PDF',
                        className: 'bg-danger',
                        footer: true
                    },
                    {
                        text: 'Todos',
                        action: function ( e, dt, node, config ) {
                            // Limpa o filtro para mostrar todos os boletos
                            boletos.search('').draw();
                        },
                        className: 'bg-info'
                    },
                    {
                        text: 'Hoje',
                        action: function ( e, dt, node, config ) {
                            var hoje = new Date().toLocaleDateString('pt-BR');
                            // Aplica o filtro para mostrar apenas boletos vencidos hoje
                            boletos.search(hoje).draw();
                        },
                        className: 'bg-warning'
                    }
                ],
                // Inicializa a tabela com o filtro para hoje
                initComplete: function () {
                    // Se 'filter' já estiver em 'YYYY-MM-DD', converte para 'DD/MM/YYYY'
                    var hoje = isValidDate(filter) ? formatDate(filter) : new Date().toLocaleDateString('pt-BR');

                    boletos.search(hoje).draw();
                },
                stateSave: true,              

                // Aplica o filtro ao DataTable
                if (filter) {
                    if (isValidDate(filter)) {
                        // Converte a data para o formato 'DD/MM/YYYY'
                        newDate = formatDate(filter);
                        table.search(newDate).draw();
                    }
                    else {
                        table.search(filter).draw();
                    }
                },
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
                        .column(3, { search: 'applied' }) // Calcula com base em todas as páginas filtradas
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Soma total da página atualmente visível
                    var pageTotal = api
                        .column(3, { page: 'current' })
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Atualiza o footer com o valor somado de todas as páginas filtradas
                    $(api.column(3).footer()).html(
                        new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(total)
                    );

                    // Se necessário, você pode usar o `pageTotal` para atualizar outros elementos na tela
                }
            } );
        } );
    </script>
@endpush
