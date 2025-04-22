
@extends('layout.app')

@section('title', 'Movimentações')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Movimentações</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('movimentacoes') . '?' . $request->getQueryString() }}">Movimentações</a></li>
                        <li class="breadcrumb-item active">Cadastro de {{ $item->tipo_de_movimentacao_descrita }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Cadastro de {{ $item->tipo_de_movimentacao_descrita }}</h3>
                </div>

                <div class="card-body">
                    <form action="{{ url('movimentacoes/salvar', $item->id) . '?' . $request->getQueryString() }}"
                        method="post" class="form-loading-submit"  enctype="multipart/form-data">
                        @csrf
                        <div class="row align-items-end">
                            <input type="hidden" name="id" id="id" value="{{ old('id', $item) }}">
                            <input type="hidden" name="tipo_de_movimentacao" id="tipo_de_movimentacao" value="{{ old('tipo_de_movimentacao', $item) }}">

                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Data</label>
                                <input type="date" name="pagamento" id="pagamento" class="form-control"
                                    value="{{ old('pagamento', $item) ?? now()->format('Y-m-d') }}">
                            </div>

                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Conta *</label>
                                <select name="conta_id" class="form-control" required>
                                    <option value=""> Selecione </option>
                                    @foreach($contas as $conta)
                                        <option value="{{ $conta->id }}"
                                            @if (old('conta_id', $item) == $conta->id)
                                                selected=""
                                            @endif >
                                            {{ $conta->descricao }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @if ($item->tipo_de_movimentacao == $item::ENTRADA)
                                <div class="form-group col-sm-12 col-md-3">
                                    <label class="form-label">Cliente</label>
                                    <select name="cliente_id" class="form-control">
                                        <option value=  ""> Selecione </option>
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}"
                                                @if (old('cliente_id', $item) == $cliente->id)
                                                    selected=""
                                                @endif >
                                                {{ $cliente->descricao }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="form-group col-sm-12 col-md-3">
                                    <label class="form-label">Fornecedor / Funcionário</label>
                                    <select name="fornecedor_id" class="form-control">
                                        <option value=""> Selecione </option>
                                        @foreach($fornecedores as $fornecedor)
                                            <option value="{{ $fornecedor->id }}"
                                                @if (old('fornecedor_id', $item) == $fornecedor->id)
                                                    selected=""
                                                @endif >
                                                {{ $fornecedor->descricao }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif                    

                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Valor *</label>
                                <input type="text" name="valor" id="valor"
                                    class="form-control valor-mask-input"
                                    value="{{ old('valor', $item) }}" required>
                            </div>

                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Motivo *</label>
                                    <input type="text" name="motivo" id="motivo" class="form-control"
                                        placeholder="informe.." value="{{ old('motivo', $item) }}" required>
                                </div>
                            </div>

                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Tipo de Pagamento</label>
                                <select name="tipo_pagamento" class="form-control">
                                    <option value=""> Selecione </option>
                                    @foreach($item::TIPO_PAGAMENTO as $tipo)
                                        <option value="{{ $tipo }}"
                                            @if (old('tipo_pagamento', $item) == $tipo)
                                                selected=""
                                            @endif >
                                            {{ $tipo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-sm-12 col-md-4">
                                <label class="form-label">
                                    Arquivo (PDF)
                                    @if($item->caminho_arquivo_pdf)
                                        <a href="{{ Storage::url($item->caminho_arquivo_pdf) }}" target="_blank">
                                            .. abrir arquivo
                                        </a>
                                    @endif
                                </label>
                                <input type="file" name="arquivo_pdf" id="arquivo_pdf" class="form-control-file" accept="application/pdf">
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
                                <a href="{{ url('movimentacoes') . '?' . $request->getQueryString() }}" class="btn btn-info">
                                    <i class="fas fa-angle-double-left"></i>
                                    Voltar
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <form id="form_excluir" action="{{ url('movimentacoes/excluir', $item->id) . '?' . $request->getQueryString() }}" method="post">
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
