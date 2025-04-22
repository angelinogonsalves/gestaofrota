
@extends('layout.app')

@section('title', 'Notas')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Notas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item active">Notas</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <a href="{{ url('notas/cadastro') }}" class="btn btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Adicionar Nota
                    </a>
                </div>
                <div class="card-body table-responsive p-2">
                    <table id="notas" class="table table-bordered table-hover">
                        <caption></caption>
                        <thead>
                            <tr>
                                <th>Descrição</th>
                                <th>Empresa</th>
                                <th>Nota</th>
                                <th>Valor</th>
                                <th>Imposto</th>
                                <th>Emissão</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($collection as $item)
                                <tr>
                                    <td>{{ $item->descricao }}</td>
                                    <td>{{ $item->empresa }}</td>
                                    <td>{{ $item->nota }}</td>
                                    <td>@money($item->valor)</td>
                                    <td>@money($item->imposto)</td>
                                    <td>@date($item->emissao)</td>
                                    <td class="d-flex">
                                        <div class="p-1">
                                            <a class="btn btn-sm btn-primary" href="{{ url('notas/cadastro', [$item->id]) }}">
                                                <i class="fas fa-edit"> </i> Editar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>Não há dados</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
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
            var notas = $('#notas').DataTable( {
                language:
                    {
                        url: "{{asset('plugins/datatables/datatable-pt-BR.json')}}"
                    },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Exportar para Excel',
                        className: 'bg-success'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'Exportar para PDF',
                        className: 'bg-danger' // Defina a classe como btn-danger para tornar o botão vermelho
                    }
                ],
                stateSave: true,
            } );
        } );
    </script>
@endpush
