
@extends('layout.app')

@section('title', 'Boletos')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Boletos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('boletos') }}">Boletos</a></li>
                        <li class="breadcrumb-item active">Cadastro</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Cadastro</h3>
                </div>

                <div class="card-body">
                    <form action="{{ url('boletos/salvar', $item->id) }}" method="post" class="form-loading-submit">
                        @csrf
                        <div class="row align-items-end">
                            <input type="hidden" name="id" id="id" value="{{ old('id', $item) }}">
                            <div class="form-group col-sm-12 col-md-4">
                                <label class="form-label">Número do Boleto</label>
                                <input type="text" name="boleto" id="boleto" class="form-control"
                                    placeholder="informe.." value="{{ old('boleto', $item) }}">
                            </div>
                            <div class="form-group col-sm-12 col-md-4">
                                <label class="form-label">Parcela do Boleto</label>
                                <input type="text" name="parcela" id="parcela" class="form-control"
                                    placeholder="informe.." value="{{ old('parcela', $item) }}">
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Descrição</label>
                                <input type="text" name="descricao" id="descricao" class="form-control"
                                    placeholder="informe.." value="{{ old('descricao', $item) }}">
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Valor</label>
                                <input type="text" name="valor" id="valor"
                                    class="form-control valor-mask-input" placeholder="100,00"
                                    value="{{ old('valor', $item) }}">
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Vencimento</label>
                                <input type="date" name="vencimento" id="vencimento" class="form-control"
                                    value="{{ old('vencimento', $item) }}">
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save" aria-hidden="true"></i>
                                    Salvar
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-sm-12 col-md-2">
                            <div class="form-group">
                                <a href="{{ url('boletos') }}" class="btn btn-info">
                                    <i class="fas fa-angle-double-left"></i>
                                    Voltar
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <form id="form_excluir" action="{{ url('boletos/excluir', $item->id) }}" method="post">
                                @csrf
                                <button type="button" class="btn btn-danger"
                                    onclick="if (confirm('Tem certeza de que deseja excluir?')) {
                                        document.getElementById('form_excluir').submit();
                                    }">
                                    <i class="fa fa-trash" aria-hidden="true"></i> Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- mostra os boletos relacionados --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Boletos Relacionados</h3>
                </div>
                <div class="card-body table-responsive p-2">
                    <table id="boletos" class="table table-bordered table-hover">
                        <caption></caption>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Descrição</th>
                                <th>Boleto</th>
                                <th>Parcela</th>
                                <th>Valor</th>
                                <th>Vencimento</th>
                                <th>Pagamento</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($collection as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->descricao }}</td>
                                    <td>{{ $item->boleto }}</td>
                                    <td>{{ $item->parcela }}</td>
                                    <td>@money($item->valor)</td>
                                    <td>@date($item->vencimento)</td>
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
                                    <td colspan="10" class="text-center">Não há dados</td>
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
            $(document).ready(function () {
                // verificar se o boleto existe
                $('#boleto').on('blur', function () {
                    let boletoNumber = $(this).val();
                    if (boletoNumber) {
                        $.ajax({
                            url: '{{ route("boletos.check") }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                boleto: boletoNumber
                            },
                            success: function (response) {
                                if (response.exists) {
                                    alert('Este boleto já está cadastrado no sistema.');
                                }
                            },
                            error: function () {
                                alert('Erro ao verificar o boleto.');
                            }
                        });
                    }
                });
            });
        </script>
@endpush
