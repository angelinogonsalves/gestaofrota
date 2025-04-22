
@extends('layout.app')

@section('title', 'Contas')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Contas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('contas') }}">Contas</a></li>
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
                    <form action="{{ url('contas/salvar', $item->id) }}" method="post" class="form-loading-submit">
                        @csrf
                        <div class="row align-items-end">
                            <input type="hidden" name="id" id="id" value="{{ old('id', $item) }}">
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Descrição *</label>
                                    <input type="text" name="descricao" id="descricao" class="form-control"
                                        placeholder="informe.." value="{{ old('descricao', $item) }}" required>
                                </div>
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Saldo da Conta *</label>
                                <input type="text" name="saldo" id="saldo"
                                    class="form-control valor-mask-input" placeholder="100,00"
                                    value="{{ old('saldo', $item) }}" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Data de Atualização *</label>
                                <input type="date" name="data_atualizacao" id="data_atualizacao" class="form-control"
                                    value="{{ old('data_atualizacao', $item) ?? now()->format('Y-m-d') }}" required>
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
                                <a href="{{ url('contas') }}" class="btn btn-info">
                                    <i class="fas fa-angle-double-left"></i>
                                    Voltar
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <form id="form_excluir" action="{{ url('contas/excluir', $item->id) }}" method="post">
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
