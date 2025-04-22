
@extends('layout.app')

@section('title', 'Produtos')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Produtos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('produtos') }}">Produtos</a></li>
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
                    <h3 class="card-title">Produtos</h3>
                </div>

                <div class="card-body">
                    <form action="{{ url('produtos/salvar', $item->id) }}" method="post" class="form-loading-submit">
                        @csrf
                        <div class="row align-items-end">
                            <input type="hidden" name="id" id="id" value="{{ old('id', $item->id) }}">
                            <div class="col-sm-12 col-md-3 form-group">
                                <label class="form-label">Código de Barras *</label>
                                <input type="text" name="codigo_de_barras" id="codigo_de_barras" class="form-control"
                                    placeholder="Informe.." value="{{ old('codigo_de_barras', $item) }}" required>
                            </div>
                            <div class="col-sm-12 col-md-3 form-group">
                                <label class="form-label">Nome *</label>
                                <input type="text" name="nome" id="nome" class="form-control"
                                    placeholder="Informe.." value="{{ old('nome', $item) }}" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Valor Unitário *</label>
                                <input type="text" name="valor_unitario" id="valor_unitario"
                                    class="form-control valor-mask-input atualiza-valores" placeholder="100,00"
                                    value="{{ old('valor_unitario', $item) }}" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Valor Total *</label>
                                <input type="text" name="valor_total" id="valor_total"
                                    class="form-control valor-mask-input" placeholder="100,00"
                                    value="{{ old('valor_total', $item) }}" required>
                            </div>
                            <div class="col-sm-12 col-md-3 form-group">
                                <label class="form-label">Unidade de medida *</label>
                                <input type="text" name="unidade_de_medida" id="unidade_de_medida" class="form-control"
                                    placeholder="Informe.." value="{{ old('unidade_de_medida', $item) }}" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Quantidade em estoque *</label>
                                <input type="text" name="quantidade_em_estoque" id="quantidade_em_estoque"
                                    class="form-control litros-mask-input atualiza-valores" placeholder="100,00"
                                    value="{{ old('quantidade_em_estoque', $item) }}" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-2">
                                <label class="form-label">Data de Atualização *</label>
                                <input type="date" name="data_atualizacao" id="data_atualizacao" class="form-control"
                                    value="{{ now()->format('Y-m-d') }}" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-2">
                                <label class="form-label">Última Atualização</label>
                                <input type="date" name="data_ultima_atualizacao" id="data_ultima_atualizacao" class="form-control"
                                    value="{{ $item->data_atualizacao }}" disabled>
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
                            <a href="{{ url('produtos') }}" class="btn btn-info">
                                <i class="fas fa-angle-double-left"></i>
                                Voltar
                            </a>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <form id="form_excluir" action="{{ url('produtos/excluir', $item->id) }}" method="post">
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

            {{-- mostra o histórico de movimentação do produto --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Histórico</h3>
                </div>
                <div class="card-body table-responsive p-2">
                    <table id="historico_produtos" class="table table-bordered table-hover">
                        <thead> 
                            <tr>
                                <th>Data</th>
                                <th>Usuário</th>
                                <th>Quantidade</th>
                                <th>Ação</th>
                                <th>Valor</th>
                                <th>Quem Retirou</th>
                                <th>Quem Recebeu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($item->movimentacaoDeProduto as $movimentacao)
                                <tr>
                                    <td>@datetime($movimentacao->data_atualizacao)</td>
                                    <td>{{ @$movimentacao->user->nome }}</td>
                                    <td>@litros($movimentacao->quantidade) {{ $item->unidade_de_medida }}</td>
                                    <td>{{ $item::TIPO_MOVIMENTACAO[$movimentacao->tipo_de_movimentacao] }}</td>
                                    <td>@money($movimentacao->valor_total)</td>
                                    <td>{{ @$movimentacao->responsavel_retirada }}</td>
                                    <td>{{ @$movimentacao->responsavel_recebimento }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td>Não há dados</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).on("change", ".atualiza-valores", function () {                
            // Obtendo os valores inseridos
            var valor_unitario = parseFloat($("#valor_unitario").val().replace(".", "").replace(",", "."));
            var quantidade_em_estoque = parseFloat($("#quantidade_em_estoque").val().replace(".", "").replace(",", "."));

            // Verificando se os valores são números válidos
            if (!isNaN(valor_unitario) && !isNaN(quantidade_em_estoque)) {
                var valor_total = valor_unitario * quantidade_em_estoque;                    
                // Formatando para usar vírgula como separador decimal
                $("#valor_unitario").val(valor_unitario.toFixed(2).replace('.', ','));
                $("#quantidade_em_estoque").val(quantidade_em_estoque.toFixed(2).replace('.', ','));
                // Definindo o valor calculado no campo 'valor_total'
                $("#valor_total").val(valor_total.toFixed(2).replace('.', ','));
            } else {
                console.log('Valores inválidos');
            }
            
            // Reaplicando a máscara para valor_unitario
            $("#valor_unitario").unmask().mask('#.##0,00', { reverse: true });
            $("#quantidade_em_estoque").unmask().mask('#.##0,00', { reverse: true });
            $("#valor_total").unmask().mask('#.##0,00', { reverse: true });
        });
    </script>
@endpush