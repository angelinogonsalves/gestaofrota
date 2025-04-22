
@extends('layout.app')

@section('title', 'Despesas')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Despesas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('despesas') . '?' . $request->getQueryString() }}">Despesas</a></li>
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
                    <form action="{{ url('despesas/salvar', $item->id) . '?' . $request->getQueryString() }}" method="post" class="form-loading-submit">
                        @csrf
                        <div class="row align-items-end">
                            <input type="hidden" name="id" id="id" value="{{ old('id', $item) }}">
                            <div class="form-group col-sm-12 col-md-4">
                                <label class="form-label">Veículo *</label>
                                <select name="veiculo_id" id="veiculo_id" class="form-control" required>
                                    <option value=""> Selecione </option>
                                    @foreach($veiculos as $veiculo)
                                        <option value="{{ $veiculo->id }}"
                                            @if (old('veiculo_id', $item) == $veiculo->id)
                                                selected=""
                                            @endif >
                                            {{ $veiculo->nome }} - {{ $veiculo->placa }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-12 col-md-4">
                                <label class="form-label">Tipo de Despesa *</label>
                                <select name="tipo_despesa_id" id="tipo_despesa_id" class="form-control" required>
                                    <option value=""> Selecione </option>
                                    @foreach($tipoDespesas as $tipoDespesa)
                                        <option value="{{ $tipoDespesa->id }}"
                                            @if (old('tipo_despesa_id', $item) == $tipoDespesa->id)
                                                selected=""
                                            @endif >
                                            {{ $tipoDespesa->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label class="form-label">Empresa</label>
                                <div class="form-group">
                                    <input type="text" name="empresa" id="empresa" class="form-control"
                                        placeholder="informe.." value="{{ old('empresa', $item) }}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label class="form-label">Descrição</label>
                                <div class="form-group">
                                    <input type="text" name="descricao" id="descricao" class="form-control"
                                        placeholder="informe.." value="{{ old('descricao', $item) }}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Valor *</label>
                                    <input type="text" name="valor" id="valor" class="form-control valor-mask-input"
                                        placeholder="100,00" value="{{ old('valor', $item) }}" required>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Data *</label>
                                    <input type="date" name="data" id="data" class="form-control"
                                        value="{{ old('data', $item) ?? now()->format('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-save" aria-hidden="true"></i>
                                        Salvar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-sm-12 col-md-2">
                            <div class="form-group">
                                <a href="{{ url('despesas') . '?' . $request->getQueryString() }}" class="btn btn-info">
                                    <i class="fas fa-angle-double-left"></i>
                                    Voltar
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <form id="form_excluir" action="{{ url('despesas/excluir', $item->id) . '?' . $request->getQueryString() }}" method="post">
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
        </div>
    </section>
@endsection

@push('scripts')
        <script>
            $('#tipo_despesa_id, #veiculo_id').change(function() {
                var tipoDespesaSelecionado = $('#tipo_despesa_id').val();
                var veiculoSelecionado = $('#veiculo_id').val();

                // Envio da requisição AJAX
                $.ajax({
                    method: 'GET',
                    url: '{{ url('despesas/calcular') }}',
                    data: {
                        tipoDespesa: tipoDespesaSelecionado,
                        veiculo: veiculoSelecionado
                    },
                    success: function(response) {
                        $('#valor').val(response.valorCalculado);
                        // aplica mascara novamente
                        $('#valor').unmask();
                        $('#valor').mask('#.##0,00', { reverse: true });
                    },
                    error: function(error) {
                        console.error('Erro ao calcular a despesa:', error);
                    }
                });
            });
        </script>
@endpush
