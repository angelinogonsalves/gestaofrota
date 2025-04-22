
@extends('layout.app')

@section('title', 'Locais')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Locais</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('locais') }}">Locais</a></li>
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
                    <form action="{{ url('locais/salvar', $item->id) }}" method="post" class="form-loading-submit">
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
                            <div class="col-sm-12 col-md-6">
                                <label class="form-label">Endereço</label>
                                <div class="form-group">
                                    <input type="text" name="endereco" id="endereco" class="form-control"
                                        placeholder="informe.." value="{{ old('endereco', $item) }}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="form-label">Cidade</label>
                                <div class="form-group">
                                    <input type="text" name="cidade" id="cidade" class="form-control"
                                        placeholder="informe.." value="{{ old('cidade', $item) }}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="form-label">Estado</label>
                                <div class="form-group">
                                    <input type="text" name="estado" id="estado" class="form-control"
                                        placeholder="informe.." value="{{ old('estado', $item) }}">
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
                                <a href="{{ url('locais') }}" class="btn btn-info">
                                    <i class="fas fa-angle-double-left"></i>
                                    Voltar
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <form id="form_excluir" action="{{ url('locais/excluir', $item->id) }}" method="post">
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
