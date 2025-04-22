
@extends('layout.app')

@section('title', 'Notas')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Notas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('notas') }}">Notas</a></li>
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
                    <form action="{{ url('notas/salvar', $item->id) }}" method="post" class="form-loading-submit">
                        @csrf
                        <div class="row align-items-end">
                            <input type="hidden" name="id" id="id" value="{{ old('id', $item) }}">
                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Empresa</label>
                                <input type="text" name="empresa" id="empresa" class="form-control"
                                    placeholder="informe.." value="{{ old('empresa', $item) }}">
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Número da Nota</label>
                                <input type="text" name="nota" id="nota" class="form-control"
                                    placeholder="informe.." value="{{ old('nota', $item) }}">
                            </div>
                            <div class="form-group col-sm-12 col-md-2">
                                <label class="form-label">Descrição</label>
                                <input type="text" name="descricao" id="descricao" class="form-control"
                                    placeholder="informe.." value="{{ old('descricao', $item) }}">
                            </div>
                            <div class="form-group col-sm-12 col-md-2">
                                <label class="form-label">Valor</label>
                                <input type="text" name="valor" id="valor"
                                    class="form-control valor-mask-input" placeholder="100,00"
                                    value="{{ old('valor', $item) }}">
                            </div>
                            <div class="form-group col-sm-12 col-md-2">
                                <label class="form-label">Imposto</label>
                                <input type="text" name="imposto" id="imposto"
                                    class="form-control valor-mask-input" placeholder="100,00"
                                    value="{{ old('imposto', $item) }}">
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Emissão</label>
                                <input type="date" name="emissao" id="emissao" class="form-control"
                                    value="{{ old('emissao', $item) }}">
                            </div>
                            <div class="form-group col-sm-12 col-md-12">
                                <label class="form-label">Observação</label>
                                <textarea id="observacao" name="observacao" rows="3" maxlength="2500" class="form-control">{{ old('observacao', $item) }}</textarea>
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save" aria-hidden="true"></i>
                                    Salvar
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-sm-12 col-md-2">
                            <div class="form-group">
                                <a href="{{ url('notas') }}" class="btn btn-info">
                                    <i class="fas fa-angle-double-left"></i>
                                    Voltar
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <form id="form_excluir" action="{{ url('notas/excluir', $item->id) }}" method="post">
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
            $(document).ready(function () {
                // verificar se o boleto existe
                $('#nota').on('blur', function () {
                    let nota = $(this).val();
                    if (nota) {
                        $.ajax({
                            url: '{{ route("notas.check") }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                nota: nota
                            },
                            success: function (response) {
                                if (response.exists) {
                                    alert('Esta nota já está cadastrada no sistema.');
                                }
                            },
                            error: function () {
                                alert('Erro ao verificar a nota.');
                            }
                        });
                    }
                });
            });
        </script>
@endpush
