
@extends('layout.app')

@section('title', 'Tipos de Veículos')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tipos de Veículos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('tipo-veiculos') }}">Tipos de Veículos</a></li>
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
                    <form action="{{ url('tipo-veiculos/salvar', $item->id) }}" method="post" class="form-loading-submit">
                        @csrf
                        <div class="row align-items-end">
                            <input type="hidden" name="id" id="id" value="{{ old('id', $item) }}">
                            <div class="col-sm-12 col-md-6">
                                <label class="form-label">Nome *</label>
                                <div class="form-group">
                                    <input type="text" name="nome" id="nome" class="form-control"
                                        placeholder="informe.." value="{{ old('nome', $item) }}" required>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-2">
                                <label class="form-label">Faz frete? *</label>
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="faz_frete" id="faz_frete_sim"
                                            value="1" {{ (old('faz_frete', $item->faz_frete) == 1 ? 'checked' : '') }}>
                                        <label class="form-check-label" for="faz_frete_sim">Sim</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="faz_frete" id="faz_frete_nao"
                                            value="0" {{ (old('faz_frete', $item->faz_frete) == 0 ? 'checked' : '') }}>
                                        <label class="form-check-label" for="faz_frete_nao">Não</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="form-label">KM para cálculo da próxima troca de óleo do motor *</label>
                                <div class="form-group">
                                    <input type="text" name="prox_troca_oleo_motor" id="prox_troca_oleo_motor" class="form-control"
                                        placeholder="informe.." value="{{ old('prox_troca_oleo_motor', $item) ?? $prox_troca_oleo_motor }}" required>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="form-label">KM para cálculo da próxima troca de óleo da caixa *</label>
                                <div class="form-group">
                                    <input type="text" name="prox_troca_oleo_caixa" id="prox_troca_oleo_caixa" class="form-control"
                                        placeholder="informe.." value="{{ old('prox_troca_oleo_caixa', $item) ?? $prox_troca_oleo_caixa }}" required>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="form-label">KM para cálculo da próxima troca de óleo do diferencial *</label>
                                <div class="form-group">
                                    <input type="text" name="prox_troca_oleo_diferencial" id="prox_troca_oleo_diferencial" class="form-control"
                                        placeholder="informe.." value="{{ old('prox_troca_oleo_diferencial', $item) ?? $prox_troca_oleo_diferencial }}" required>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label>Tipo de Usuário Responsável *</label>
                                    <select class="form-control select" id="tipo_usuario_responsavel" name="tipo_usuario_responsavel">
                                        <option value=""
                                            @if (!old('tipo_usuario_responsavel', $item))
                                                selected=""
                                            @endif >
                                            0 - Todos
                                        </option>
                                        <option value="1"
                                            @if (old('tipo_usuario_responsavel', $item) == '1')
                                                selected=""
                                            @endif >
                                            1 - Frota
                                        </option>
                                        <option value="2"
                                            @if (old('tipo_usuario_responsavel', $item) == '2')
                                                selected=""
                                            @endif >
                                            2 - Financeiro
                                        </option>
                                        <option value="3"
                                            @if (old('tipo_usuario_responsavel', $item) == '3')
                                                selected=""
                                            @endif >
                                            3 - Gerente de Contas
                                        </option>
                                    </select>
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
                                <a href="{{ url('tipo-veiculos') }}" class="btn btn-info">
                                    <i class="fas fa-angle-double-left"></i>
                                    Voltar
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <form id="form_excluir" action="{{ url('tipo-veiculos/excluir', $item->id) }}" method="post">
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
