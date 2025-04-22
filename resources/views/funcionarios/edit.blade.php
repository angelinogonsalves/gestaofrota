
@extends('layout.app')

@section('title', 'Funcionários')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Funcionários</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('funcionarios') }}">Funcionários</a></li>
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
                    <form action="{{ url('funcionarios/salvar', $item->id) }}" method="post" class="form-loading-submit">
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
                                    <label class="form-label">Cargo *</label>
                                    <select name="cargo_id" id="cargo_id" class="form-control" required>
                                        <option value=""> Selecione </option>
                                        @foreach($cargos as $cargo)
                                            <option value="{{ $cargo->id }}"
                                                @if (old('cargo_id', $item) == $cargo->id)
                                                    selected=""
                                                @endif >
                                                {{ $cargo->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-label">Salário *</label>
                                    <input type="text" name="salario" id="salario" class="form-control valor-mask-input"
                                        placeholder="0,00" value="{{ old('salario', $item) }}" required>
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
                                <a href="{{ url('funcionarios') }}" class="btn btn-info">
                                    <i class="fas fa-angle-double-left"></i>
                                    Voltar
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <form id="form_excluir" action="{{ url('funcionarios/excluir', $item->id) }}" method="post">
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
