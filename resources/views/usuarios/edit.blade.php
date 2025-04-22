
@extends('layout.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Usuários</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('usuarios') }}">Usuários</a></li>
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
                    <form action="{{ url('usuarios/salvar', $item->id) }}" method="post">
                        @csrf
                        <div class="row align-items-end">
                            <input type="hidden" name="id" value="{{ old('id', $item) }}">
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label>Tipo de Usuário *</label>
                                    <select class="form-control select" id="tipo_usuario" name="tipo_usuario" required>
                                        <option value="1"
                                            @if (old('tipo_usuario', $item) == '1')
                                                selected=""
                                            @endif >
                                            1 - Frota
                                        </option>
                                        <option value="2"
                                            @if (old('tipo_usuario', $item) == '2')
                                                selected=""
                                            @endif >
                                            2 - Financeiro
                                        </option>
                                        <option value="3"
                                            @if (old('tipo_usuario', $item) == '3')
                                                selected=""
                                            @endif >
                                            3 - Gerente de Contas
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label>Nome Completo *</label>
                                    <input type="text" name="nome" class="form-control" placeholder="informe.."
                                        value="{{ old('nome', $item) }}" required>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label>CPF</label>
                                    <input type="text" name="cpf" class="form-control" placeholder="informe.."
                                        value="{{ old('cpf', $item) }}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label>E-mail *</label>
                                    <input type="email" id="ra" name="email" class="form-control" placeholder="informe.."
                                        value="{{ old('email', $item) }}" required>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label>Senha @if(!$item->id) * @endif</label>
                                    <input type="password" name="password" class="form-control" placeholder="informe.." @if(!$item->id) required @endif>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label>Repetir Senha @if(!$item->id) * @endif</label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="informe.." @if(!$item->id) required @endif>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
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
                                <a href="{{ url('usuarios') }}" class="btn btn-info">
                                    <i class="fas fa-angle-double-left"></i>
                                    Voltar
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <form id="form_excluir" action="{{ url('usuarios/excluir', $item->id) }}" method="post">
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
