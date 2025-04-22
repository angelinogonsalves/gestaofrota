
@extends('layout.app')

@section('title', 'Fretes')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Fretes</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('fretes') . '?' . $request->getQueryString() }}">Fretes</a></li>
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
                    <form action="{{ url('fretes/salvar', $item->id) . '?' . $request->getQueryString() }}" method="post" class="form-loading-submit">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{ old('id', $item) }}">
                        <div class="row align-items-end">
                            <div class="col-sm-12 col-md-3 form-group">
                                <label class="form-label">Veículo *</label>
                                <select name="veiculo_id" id="veiculo_id" class="form-control" required>
                                    <option value=""> Selecione </option>
                                    @foreach($veiculos as  $veiculo)
                                        <option value="{{ $veiculo->id }}"
                                            @if (old('veiculo_id', $item) == $veiculo->id)
                                                selected=""
                                            @endif >
                                            {{ $veiculo->nome }} - {{ $veiculo->placa }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-3 form-group">
                                <label class="form-label">Local de Origem Carregamento *</label>
                                <select name="local_origem_id" id="local_origem_id" class="form-control" required>
                                    <option value=""> Selecione </option>
                                    @foreach($locaisOrigem as $localOrigem)
                                        <option value="{{ $localOrigem->id }}"
                                            @if (old('local_origem_id', $item) == $localOrigem->id)
                                                selected=""
                                            @endif >
                                            {{ $localOrigem->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-3 form-group">
                                <label class="form-label">Local de Destino Entrega *</label>
                                <select name="local_destino_id" id="local_destino_id" class="form-control" required>
                                    <option value=""> Selecione </option>
                                    @foreach($locaisDestino as $localDestino)
                                        <option value="{{ $localDestino->id }}"
                                            @if (old('local_destino_id', $item) == $localDestino->id)
                                                selected=""
                                            @endif >
                                            {{ $localDestino->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Removido a pedido do cliente --}}
                            {{-- <div class="col-sm-12 col-md-3 form-group">
                                <label class="form-label">Empresa *</label>
                                <select name="local_empresa_id" id="local_empresa_id" class="form-control" required>
                                    <option value=""> Selecione </option>
                                    @foreach($locaisEmpresa as $localEmpresa)
                                        <option value="{{ $localEmpresa->id }}"
                                            @if (old('local_empresa_id', $item) == $localEmpresa->id)
                                                selected=""
                                            @endif >
                                            {{ $localEmpresa->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="col-sm-12 col-md-3 form-group">
                                <label class="form-label">Data de Saída</label>
                                <input type="date" name="data_saida" id="data_saida" class="form-control"
                                    value="{{ old('data_saida', $item) ?? now()->format('Y-m-d') }}">
                            </div>
                            <div class="col-sm-12 col-md-3 form-group">
                                <label class="form-label">Cortador</label>
                                <select name="funcionario_cortador_id" id="funcionario_cortador_id" class="form-control">
                                    <option value=""> Selecione </option>
                                    @foreach($cortadores as $cortador)
                                        <option value="{{ $cortador->id }}"
                                            @if (old('funcionario_cortador_id', $item) == $cortador->id)
                                                selected=""
                                            @endif >
                                            {{ $cortador->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-3 form-group">
                                <label class="form-label">Carregador</label>
                                <select name="funcionario_carregador_id" id="funcionario_carregador_id"class="form-control">
                                    <option value=""> Selecione </option>
                                    @foreach($carregadores as $carregador)
                                        <option value="{{ $carregador->id }}"
                                            @if (old('funcionario_carregador_id', $item) == $carregador->id)
                                                selected=""
                                            @endif >
                                            {{ $carregador->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-3 form-group">
                                <label class="form-label">Espessura</label>
                                <input type="text" name="espessura" id="espessura" class="form-control"
                                    placeholder="Informe.." value="{{ old('espessura', $item) }}">
                            </div>
                            {{-- Removido a pedido do cliente --}}
                            {{-- <div class="col-sm-12 col-md-3 form-group">
                                <label class="form-label">Data de Saída</label>
                                <input type="date" name="data_saida" id="data_saida" class="form-control"
                                    value="{{ old('data_saida', $item) }}">
                            </div> --}}
                            <div class="col-sm-12 col-md-3 form-group">
                                <label class="form-label">Peso (kg)</label>
                                <input type="text" name="peso" id="peso" class="form-control peso-mask-input atualiza-valores-peso"
                                    placeholder="10,0" value="{{ old('peso', $item) }}">
                            </div>
                            <div class="col-sm-12 col-md-3 form-group">
                                <label class="form-label">Valor por Tonelada</label>
                                <input type="text" name="valor_tonelada" id="valor_tonelada"
                                    class="form-control valor-mask-input atualiza-valores-peso" placeholder="100,00"
                                    value="{{ old('valor_tonelada', $item) }}">
                            </div>
                            <div class="col-sm-12 col-md-3 form-group">
                                <label class="form-label">Valor Total</label>
                                <input type="text" name="valor_total" id="valor_total"
                                    class="form-control valor-mask-input" placeholder="100,00"
                                    value="{{ old('valor_total', $item) }}">
                            </div>
                            {{-- Removido a pedido do cliente --}}
                            {{-- <div class="col-sm-12 col-md-3 form-group">
                                <label class="form-label">Data de Chegada</label>
                                <input type="date" name="data_chegada" id="data_chegada" class="form-control"
                                    value="{{ old('data_chegada', $item) }}">
                            </div> --}}
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="form-label">KM Saída</label>
                                    <input type="text" name="km_saida" id="km_saida" class="form-control km-mask-input atualiza-valores-distancia"
                                        placeholder="10.000,0" value="{{ old('km_saida', $item) }}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="form-label">KM Chegada</label>
                                    <input type="text" name="km_chegada" id="km_chegada" class="form-control km-mask-input atualiza-valores-distancia"
                                        placeholder="10.000,0" value="{{ old('km_chegada', $item) }}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3 form-group">
                                <label class="form-label">Distância</label>
                                <input type="text" name="distancia" id="distancia" class="form-control km-mask-input"
                                    placeholder="10.000,0" value="{{ old('distancia', $item) }}">
                            </div>
                            <div class="col-sm-12 col-md-3 form-group">
                                <label class="form-label">Comissão</label>
                                <input type="text" name="comissao" id="comissao"
                                    class="form-control valor-mask-input" placeholder="100,00"
                                    value="{{ old('comissao', $item) }}">
                            </div>
                            <div class="col-sm-12 col-md-3 form-group"">
                                <label class="form-label">Observação</label>
                                <input type="text" name="observacao" id="observacao" class="form-control"
                                    placeholder="..." value="{{ old('observacao', $item) }}">
                            </div>
                            <div class="col-sm-12 col-md-2 form-group">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save" aria-hidden="true"></i>
                                    Salvar
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-sm-12 col-md-2 form-group">
                            <a href="{{ url('fretes') . '?' . $request->getQueryString() }}" class="btn btn-info">
                                <i class="fas fa-angle-double-left"></i>
                                Voltar
                            </a>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <form id="form_excluir" action="{{ url('fretes/excluir', $item->id) . '?' . $request->getQueryString() }}" method="post">
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
            $(document).on("change", ".atualiza-valores-distancia", function () {                
                // Obtendo os valores inseridos
                var km_saida = parseFloat($("#km_saida").val().replace(".", "").replace(",", "."));
                var km_chegada = parseFloat($("#km_chegada").val().replace(".", "").replace(",", "."));

                // Verificando se os valores são números válidos
                if (!isNaN(km_saida) && !isNaN(km_chegada)) {
                    var distancia = km_chegada - km_saida;                    
                    // Formatando para usar vírgula como separador decimal
                    $("#km_saida").val(km_saida.toFixed(1).replace('.', ','));
                    $("#km_chegada").val(km_chegada.toFixed(1).replace('.', ','));
                    // Definindo o valor calculado no campo 'distancia'
                    $("#distancia").val(distancia.toFixed(1).replace('.', ','));
                } else {
                    console.log('Valores inválidos');
                }
                
                // Reaplicando a máscara para valor_unitario
                $("#km_saida").unmask().mask('#.##0,0', { reverse: true });
                $("#km_chegada").unmask().mask('#.##0,0', { reverse: true });
                $("#distancia").unmask().mask('#.##0,0', { reverse: true });
            });

            $(document).on("change", ".atualiza-valores-peso", function () {                
                // Obtendo os valores inseridos
                var peso = parseFloat($("#peso").val().replace(".", "").replace(",", "."));
                var valor_tonelada = parseFloat($("#valor_tonelada").val().replace(".", "").replace(",", "."));

                // Verificando se os valores são números válidos
                if (!isNaN(peso) && !isNaN(valor_tonelada)) {
                    // faz a transformação por tonelada 1 ton = 1.000 kg
                    var valor_total = peso * valor_tonelada / 1000;                    
                    // Formatando para usar vírgula como separador decimal
                    $("#peso").val(peso.toFixed(2).replace('.', ','));
                    $("#valor_tonelada").val(valor_tonelada.toFixed(2).replace('.', ','));
                    // Definindo o valor calculado no campo 'valor_total'
                    $("#valor_total").val(valor_total.toFixed(2).replace('.', ','));
                } else {
                    console.log('Valores inválidos');
                }
                
                // Reaplicando a máscara para valor_unitario
                $("#peso").unmask().mask('#.##0,00', { reverse: true });
                $("#valor_tonelada").unmask().mask('#.##0,00', { reverse: true });
                $("#valor_total").unmask().mask('#.##0,00', { reverse: true });
            });
        </script>
@endpush
