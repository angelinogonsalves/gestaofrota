
@extends('layout.app')

@section('title', 'Abastecimentos')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Abastecimentos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('abastecimentos') . '?' . $request->getQueryString() }}">Abastecimentos</a></li>
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
                    <form action="{{ url('abastecimentos/salvar', $item->id) . '?' . $request->getQueryString() }}" method="post" class="form-loading-submit">
                        @csrf
                        <div class="alert alert-light" id="vehicle-alert" style="display: none;">
                            <span id="vehicle-info"></span>
                        </div>
                        <div class="row align-items-end">
                            <input type="hidden" name="id" id="id" value="{{ old('id', $item) }}">
                            <div class="col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-label">Data *</label>
                                    <input type="date" name="data" id="data" class="form-control"
                                        value="{{ old('data', $item) ?? now()->format('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Veículo *</label>
                                    <select name="veiculo_id" id="veiculo_id" class="form-control" required>
                                        <option value=""> Selecione </option>
                                        @foreach($veiculos as $veiculo)
                                            <option value="{{ $veiculo->id }}"
                                                data-km="@km($veiculo->km_prox_motor)"
                                                @if (old('veiculo_id', $item) == $veiculo->id)
                                                    selected=""
                                                @endif >
                                                {{ $veiculo->nome }} - {{ $veiculo->placa }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Tipo de Combustível *</label>
                                    <select name="combustivel" id="combustivel" class="form-control" required>
                                        <option value=""> Selecione </option>
                                        @foreach($tipoCombustiveis as $tipoCombustivel)
                                            <option value="{{ $tipoCombustivel }}"
                                                @if (old('combustivel', $item) == $tipoCombustivel)
                                                    selected=""
                                                @endif >
                                                {{ $tipoCombustivel }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-sm-12 col-md-4">
                                <label class="form-label">Local do Abastecimento</label>
                                <input type="text" name="local_abastecimento" id="local_abastecimento" class="form-control"
                                    placeholder="informe.." value="{{ old('local_abastecimento', $item) }}">
                            </div>
                            <div class="form-group col-sm-12 col-md-2">
                                <label class="form-label">Descrição</label>
                                <input type="text" name="descricao" id="descricao" class="form-control"
                                    placeholder="informe.." value="{{ old('descricao', $item) }}">
                            </div>
                            <div class="col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-label">KM</label>
                                    <input type="text" name="km" id="km" class="form-control km-mask-input"
                                        placeholder="10.000,0" value="{{ old('km', $item) }}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-label">Litros *</label>
                                    <input type="text" name="litros" id="litros" class="form-control litros-mask-input atualiza-valores"
                                        placeholder="100,50" value="{{ old('litros', $item) }}" required>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-label">Valor Unitário *</label>
                                    <input type="text" name="valor_unitario" id="valor_unitario" class="form-control valor-mask-input atualiza-valores"
                                        placeholder="5,00" value="{{ old('valor_unitario', $item) }}" required>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-label">Valor Total *</label>
                                    <input type="text" name="valor_total" id="valor_total" class="form-control valor-mask-input"
                                        placeholder="100,00" value="{{ old('valor_total', $item) }}" required>
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
                                <a href="{{ url('abastecimentos') . '?' . $request->getQueryString() }}" class="btn btn-info">
                                    <i class="fas fa-angle-double-left"></i>
                                    Voltar
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <form id="form_excluir" action="{{ url('abastecimentos/excluir', $item->id) . '?' . $request->getQueryString() }}" method="post">
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
            // Quando houver uma mudança nos campos com classe 'atualiza-valores'
            $(document).on("change", ".atualiza-valores", function () {                
                // Obtendo os valores inseridos
                var quantidade = parseFloat($("#litros").val().replace(".", "").replace(",", "."));
                var valor_unitario = parseFloat($("#valor_unitario").val().replace(".", "").replace(",", "."));

                // Verificando se os valores são números válidos
                if (!isNaN(quantidade) && !isNaN(valor_unitario)) {
                    var valor_total = valor_unitario * quantidade;                    
                    // Formatando para usar vírgula como separador decimal
                    $("#valor_unitario").val(valor_unitario.toFixed(2).replace('.', ','));
                    // Definindo o valor calculado no campo 'valor_total'
                    $("#valor_total").val(valor_total.toFixed(2).replace('.', ','));
                } else {
                    console.log('Valores inválidos');
                }
                
                // Reaplicando a máscara para valor_unitario
                $("#valor_unitario").unmask().mask('#.##0,00', { reverse: true });
                $("#valor_total").unmask().mask('#.##0,00', { reverse: true });
            });

            // quando houver troca do veiculo
            $(document).on("change", "#veiculo_id", function () {
                var selectedOption = this.options[this.selectedIndex];
                var km = selectedOption.getAttribute('data-km');

                // Verifica se um veículo foi selecionado
                if (this.value) {
                    var alertDiv = document.getElementById('vehicle-alert');
                    var infoSpan = document.getElementById('vehicle-info');

                    // Atualiza o conteúdo do alerta
                    infoSpan.textContent = `KM da próxima troca de óleo do veículo: ${km}`;
                    alertDiv.style.display = 'block';
                } else {
                    // Oculta o alerta se nenhum veículo for selecionado
                    document.getElementById('vehicle-alert').style.display = 'none';
                }
            });
        </script>
@endpush