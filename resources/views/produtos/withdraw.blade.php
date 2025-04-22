@extends('layout.app')

@section('title', 'Movimentações do Estoque')

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
                        <li class="breadcrumb-item"><a href="{{ url('produtos') }}">Produtos</a></li>
                        <li class="breadcrumb-item active">Movimentações</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Movimentações</h3>
                </div>

                <div class="card-body">
                    <form action="{{ url('produtos/salvar') }}" method="post" id="form_estoque" class="form-loading-submit">
                        @csrf
                        <div class="row align-items-end">
                            <input type="hidden" name="url" value="{{ url('produtos/salvar') }}">
                            <input type="hidden" name="tipo_de_movimentacao" value="{{ \App\Models\Produto::SAIDA }}">
                            <input type="hidden" name="produto_id" id="produto_id" value="{{ old('produto_id') }}">
                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Código de Barras *</label>
                                <input type="text" name="produto" id="produto" class="form-control auto-preenche-valores"
                                    placeholder="Digite para buscar produtos" value="{{ old('produto') }}">
                            </div>
                            <div class="col-sm-12 col-md-3 form-group">
                                <label class="form-label">Nome *</label>
                                <div class="dropdown">
                                    <input type="text" name="nome" id="nome" class="form-control"
                                        placeholder="Digite para buscar produtos" value="{{ old('nome') }}">
                                    <div id="opcoesProdutos" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="display: none;"></div>
                                </div>
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Quantidade *</label>
                                <input type="text" name="quantidade" id="quantidade"
                                    class="form-control litros-mask-input" placeholder="100,00"
                                    value="{{ old('quantidade') }}" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-2">
                                <label class="form-label">Data de Atualização *</label>
                                <input type="date" name="data_atualizacao" id="data_atualizacao" class="form-control"
                                    value="{{ old('data_atualizacao') ?? now()->format('Y-m-d') }}" required>
                            </div>
                            <div class="col-sm-12 col-md-3 form-group">
                                <label class="form-label">Responsável pela retirada</label>
                                <input type="text" name="responsavel_retirada" id="responsavel_retirada" class="form-control"
                                    value="{{ old('responsavel_retirada') }}">
                            </div>
                            <div class="col-sm-12 col-md-3 form-group">
                                <label class="form-label">Mecânico que recebeu</label>
                                <input type="text" name="responsavel_recebimento" id="responsavel_recebimento" class="form-control"
                                    value="{{ old('responsavel_recebimento') }}">
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
                    </div>
                </div>
            </div>
        </div>
    </section>    
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Converte a variável PHP para uma variável JavaScript
            var produtos = @json($produtos);

            let opcoesProdutos = $('#opcoesProdutos');
            let inputCodigoDeBarras = $('#produto');

            $('#nome').on('input', function() {
                let termo = $(this).val();

                if (termo.length >= 3) {
                    opcoesProdutos.empty(); // Limpa as opções anteriores

                    fetch("{{ url('produtos/buscar-produtos') }}?termo=" + termo)
                        .then(response => response.json())
                        .then(produtos => {
                            produtos.forEach(produtoEncontrado => {
                                let opcaoProduto = $("<button>")
                                    .addClass("dropdown-item")
                                    .text(produtoEncontrado.nome)
                                    .on('click', function() {
                                        event.preventDefault(); // Impede o comportamento padrão
                                        inputCodigoDeBarras.val(produtoEncontrado.codigo_de_barras);
                                        inputCodigoDeBarras.change();
                                        opcoesProdutos.hide(); // Esconde o dropdown ao selecionar uma opção
                                    });

                                opcoesProdutos.append(opcaoProduto);
                            });

                            // Exibir o dropdown de produtos se houver opções
                            if (produtos.length > 0) {
                                opcoesProdutos.show();
                            } else {
                                opcoesProdutos.hide();
                            }
                        })
                        .catch(error => {
                            console.error('Erro ao buscar produtos:', error);
                        });
                } else {
                    opcoesProdutos.hide();
                }
            });

            // Fechar o dropdown ao clicar fora dele
            $(document).on('click', function(event) {
                if (!$(event.target).closest('.dropdown').length) {
                    opcoesProdutos.hide();
                }
            });
        
            // Quando preencher o código de barras
            $(".auto-preenche-valores").on("change", function () {
                // Pega o valor inserido
                var produtoSelecionado = this.value;
                url = $('#form_estoque').attr('action');

                $("#produto_id").val('');
                $("#nome").val('');
                $('#form_estoque').attr('action', url);

                // Encontrar o produto correspondente na lista de produtos
                var produtoEncontrado = produtos.find(function (produto) {
                    return produto.codigo_de_barras === produtoSelecionado;
                });

                // Preencher o id e o nome do produto se ele foi encontrado
                if (produtoEncontrado) {
                    $("#produto_id").val(produtoEncontrado.id);
                    $("#nome").val(produtoEncontrado.nome);
                    nova_url = url + '/' + $("#produto_id").val();
                    $('#form_estoque').attr('action', nova_url);
                }
            });

            $('#form_estoque').submit(function(event) {
                // Adicione sua lógica de validação aqui
                if (!$("#produto_id").val()) {
                    // Se a validação falhar, evite o envio do formulário
                    event.preventDefault();
                    // Exiba uma mensagem de erro ou faça o que for apropriado
                    alert('Produto não encotrado!');
                };
            });
        });
    </script>
@endpush
