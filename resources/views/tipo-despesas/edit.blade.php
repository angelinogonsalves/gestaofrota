
@extends('layout.app')

@section('title', 'Tipos de Despesas')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tipos de Despesas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('tipo-despesas') }}">Tipos de Despesas</a></li>
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
                    <form action="{{ url('tipo-despesas/salvar', $item->id) }}" method="post" class="form-loading-submit">
                        @csrf
                        <div class="row align-items-end">
                            <input type="hidden" name="id" id="id" value="{{ old('id', $item) }}">
                            <div class="form-group col-sm-12 col-md-5">
                                <label class="form-label">Nome *</label>
                                <input type="text" name="nome" id="nome" class="form-control"
                                    placeholder="informe.." value="{{ old('nome', $item) }}" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-2">
                                <label class="form-label">Valor Padrão</label>
                                <input type="text" name="valor_padrao" id="valor_padrao"
                                    class="form-control valor-mask-input" placeholder="0,00"
                                    value="{{ old('valor_padrao', $item) }}">
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Calculo</label>
                                <input type="text" name="calculo" id="calculo"
                                    class="form-control" value="{{ old('calculo', $item) }}">
                            </div>
                            <div class="form-group col-sm-12 col-md-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save" aria-hidden="true"></i>
                                    Salvar
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-2">
                            <a href="{{ url('tipo-despesas') }}" class="btn btn-info">
                                <i class="fas fa-angle-double-left"></i>
                                Voltar
                            </a>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <form id="form_excluir" action="{{ url('tipo-despesas/excluir', $item->id) }}" method="post">
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
