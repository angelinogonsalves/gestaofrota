
@extends('layout.app')

@section('title', 'Movimentações do Caixa')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Caixas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('caixas') }}">Caixas</a></li>
                        <li class="breadcrumb-item active">Movimentação</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Movimentações do Caixa {{$item->local->name}}</h3>
                </div>

                <div class="card-body">
                    <form action="{{ url('caixas/salvar', $item->id) }}" method="post" class="form-loading-submit">
                        @csrf
                        <div class="row align-items-end">
                            <input type="hidden" name="id" id="id" value="{{ old('id', $item->id) }}">
                            <input type="hidden" name="caixa_id" id="caixa_id" value="{{ $item->id }}">
                            <input type="hidden" name="tipo_de_movimentacao" value="{{ $item::SAIDA }}">
                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Valor *</label>
                                <input type="text" name="valor" id="valor"
                                    class="form-control valor-mask-input"
                                    value="{{ old('valor') }}" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Data de retirada *</label>
                                <input type="date" name="data_movimentacao" id="data_movimentacao" class="form-control"
                                    value="{{ old('data_movimentacao') ?? now()->format('Y-m-d') }}" required>
                            </div>
                            <div class="col-sm-12 col-md-6 form-group">
                                <label class="form-label">Motivo</label>
                                <input type="text" name="motivo" id="motivo" class="form-control"
                                    placeholder="..." value="{{ old('motivo') }}">
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
                            <a href="{{ url('caixas') }}" class="btn btn-info">
                                <i class="fas fa-angle-double-left"></i>
                                Voltar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
@endsection
