
@extends('layout.app')

@section('title', 'Veículos')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Veículos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('veiculos') }}">Veículos</a></li>
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
                    <form action="{{ url('veiculos/salvar', $item->id) }}" method="post" class="form-loading-submit">
                        @csrf
                        <div class="row align-items-end">
                            <input type="hidden" name="id" id="id" value="{{ old('id', $item) }}">
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Nome *</label>
                                    <input type="text" name="nome" id="nome" class="form-control"
                                        placeholder="informe.." value="{{ old('nome', $item) }}" required>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Placa *</label>
                                    <input type="text" name="placa" id="placa" class="form-control"
                                        placeholder="ABC-9999" value="{{ old('placa', $item) }}" required>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-label">KM *</label>
                                    <input type="text" name="km_atual" id="km_atual" class="form-control km-mask-input"
                                        placeholder="10.000,0" value="{{ old('km_atual', $item) }}" required>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Tipo de Veículo *</label>
                                    <select name="tipo_veiculo_id" id="tipo_veiculo_id" class="form-control" required>
                                        <option value=""> Selecione </option>
                                        @foreach($tipoVeiculos as $tipoVeiculo)
                                            <option value="{{ $tipoVeiculo->id }}"
                                                @if (old('tipo_veiculo_id', $item) == $tipoVeiculo->id)
                                                    selected=""
                                                @endif >
                                                {{ $tipoVeiculo->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Motorista *</label>
                                    <select name="funcionario_id" id="funcionario_id" class="form-control" required>
                                        <option value=""> Selecione </option>
                                        @foreach($motoristas as $motorista)
                                            <option value="{{ $motorista->id }}"
                                                @if (old('funcionario_id', $item) == $motorista->id)
                                                    selected=""
                                                @endif >
                                                {{ $motorista->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Valor do anual IPVA</label>
                                    <input type="text" name="ipva_total" id="ipva_total" class="form-control valor-mask-input"
                                        placeholder="0,00" value="{{ old('ipva_total', $item) }}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Valor do anual Seguro</label>
                                    <input type="text" name="seguro_total" id="seguro_total" class="form-control valor-mask-input"
                                        placeholder="0,00" value="{{ old('seguro_total', $item) }}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-label">KM da próxima de óleo do motor</label>
                                    <input type="text" name="km_prox_motor" id="km_prox_motor" class="form-control km-mask-input"
                                        placeholder="10.000,0" value="{{ old('km_prox_motor', $item) }}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-label">KM da próxima de óleo da caixa</label>
                                    <input type="text" name="km_prox_caixa" id="km_prox_caixa" class="form-control km-mask-input"
                                        placeholder="10.000,0" value="{{ old('km_prox_caixa', $item) }}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-label">KM da próxima de óleo do diferencial</label>
                                    <input type="text" name="km_prox_diferencial" id="km_prox_diferencial" class="form-control km-mask-input"
                                        placeholder="10.000,0" value="{{ old('km_prox_diferencial', $item) }}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Chassi</label>
                                    <input type="text" name="chassi" id="chassi" class="form-control"
                                        placeholder="Informe.." value="{{ old('chassi', $item) }}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-label">Ano</label>
                                    <input type="text" name="ano" id="ano" class="form-control"
                                        placeholder="Informe.." value="{{ old('ano', $item) }}">
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
                                <a href="{{ url('veiculos') }}" class="btn btn-info">
                                    <i class="fas fa-angle-double-left"></i>
                                    Voltar
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <form id="form_excluir" action="{{ url('veiculos/excluir', $item->id) }}" method="post">
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
