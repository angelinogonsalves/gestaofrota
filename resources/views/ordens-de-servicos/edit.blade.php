
@extends('layout.app')

@section('title', 'Ordens de Serviço')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manutenções</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('ordens-de-servicos') }}">Manutenções</a></li>
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
                    <form action="{{ url('ordens-de-servicos/salvar', $item->id) }}" method="post" class="form-loading-submit">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{ old('id', $item->id) }}">

                        <div class="row align-items-end">
                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Data de Solicitação *</label>
                                <input type="date" name="data_solicitacao" id="data_solicitacao" class="form-control"
                                    value="{{ old('data_solicitacao', $item) ?? now()->format('Y-m-d') }}" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Veículo *</label>
                                <select name="veiculo_id" id="veiculo_id" class="form-control" required>
                                    <option value=""> Selecione </option>
                                    @foreach($veiculos as  $veiculo)
                                        <option value="{{ $veiculo->id }}"
                                            @if (old('veiculo_id', $item) == $veiculo->id)
                                                selected=""
                                            @endif >
                                            {{ $veiculo->nome }} - {{ $veiculo->placa }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label class="form-label">Problema *</label>
                                <input type="text" name="problema" id="problema" class="form-control"
                                    placeholder="informe.." value="{{ old('problema', $item) }}" required>
                            </div>
                        </div>

                        <div class="row align-items-end">
                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Data de Início</label>
                                <input type="date" name="data_inicio" id="data_inicio" class="form-control"
                                    value="{{ old('data_inicio', $item) }}">
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <label class="form-label">Data de Fim</label>
                                <input type="date" name="data_fim" id="data_fim" class="form-control"
                                    value="{{ old('data_fim', $item) }}">
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label class="form-label">Solução</label>
                                <input type="text" name="solucao" id="solucao" class="form-control"
                                    placeholder="informe.." value="{{ old('solucao', $item) }}">
                            </div>
                            <div class="form-group col-sm-12 col-md-12">
                                <label class="form-label">Observação</label>
                                <textarea id="observacao" name="observacao" rows="3" maxlength="2500" class="form-control">{{ old('observacao', $item) }}</textarea>
                            </div>
                        </div>

                        {{-- mão de obra --}}
                        <div class="card border-info mb-3">
                            <div class="card-header text-info">
                                Mão de Obra
                            </div>
                            <div class="card-body text-info">
                                @forelse($item->ordemDeServicoFuncionario as $osf)
                                    <div id="funcionario-{{ $osf->id }}" class="linha-form row align-items-end">
                                        <input type="hidden" name="funcionarios[{{ $osf->id }}][id]"
                                            value="{{ old("funcionarios.{$osf->id}.id", $osf->id) }}">
                                        <div class="form-group col-sm-12 col-md-3">
                                            <label class="form-label">Funcionário</label>
                                            <select name="funcionarios[{{ $osf->id }}][funcionario_id]"
                                                class="form-control auto-preenche-funcionario">
                                                <option value=""> Selecione </option>
                                                @foreach($funcionarios as $funcionario)
                                                    <option value="{{ $funcionario->id }}"
                                                        @if(old("funcionarios.{$osf->id}.funcionario_id", $osf->funcionario_id) == $funcionario->id)
                                                            selected=""
                                                        @endif>
                                                        {{ $funcionario->nome }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-3">
                                            <label class="form-label">Tempo de Serviço (horas)</label>
                                            <input type="text" name="funcionarios[{{ $osf->id }}][tempo]"
                                                class="form-control litros-mask-input atualiza-valores" placeholder="1"
                                                value="{{ old("funcionarios.{$osf->id}.tempo", $osf->tempo) ?? 1}}">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-2">
                                            <label class="form-label">Valor por Hora</label>
                                            <input type="text" name="funcionarios[{{ $osf->id }}][valor_unitario]"
                                                class="form-control valor-mask-input atualiza-valores" placeholder="0,00"
                                                value="{{ old("funcionarios.{$osf->id}.valor_unitario", $osf->valor_unitario) }}">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-2">
                                            <label class="form-label">Valor Total</label>
                                            <input type="text" name="funcionarios[{{ $osf->id }}][valor_total]"
                                                class="form-control valor-mask-input" placeholder="0,00"
                                                value="{{ old("funcionarios.{$osf->id}.valor_total", $osf->valor_total) }}">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-1">
                                            <!-- botão remover -->
                                            <button type="button" class="btn btn-danger btn-remover">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-1">
                                            <!-- botão adicionar -->
                                            <button type="button" class="btn btn-success btn-adicionar">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <div id="funcionario-1" class="linha-form row align-items-end">
                                        <input type="hidden" name="funcionarios[0][id]" value="{{ old('funcionarios.0.id') }}">
                                        <div class="form-group col-sm-12 col-md-3">
                                            <label class="form-label">Funcionário</label>
                                            <select name="funcionarios[0][funcionario_id]"
                                                class="form-control auto-preenche-funcionario">
                                                <option value=""> Selecione </option>
                                                @foreach($funcionarios as $funcionario)
                                                    <option value="{{ $funcionario->id }}"
                                                        @if(old('funcionarios.0.funcionario_id') == $funcionario->id)
                                                            selected=""
                                                        @endif>
                                                        {{ $funcionario->nome }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-3">
                                            <label class="form-label">Tempo de Serviço (horas)</label>
                                            <input type="text" name="funcionarios[0][tempo]"
                                                class="form-control litros-mask-input atualiza-valores" placeholder="1"
                                                value="{{ old('funcionarios.0.tempo') ?? 1}}">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-2">
                                            <label class="form-label">Valor por Hora</label>
                                            <input type="text" name="funcionarios[0][valor_unitario]"
                                                class="form-control valor-mask-input atualiza-valores" placeholder="0,00"
                                                value="{{ old("funcionarios.0.valor_unitario") }}">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-2">
                                            <label class="form-label">Valor Total</label>
                                            <input type="text" name="funcionarios[0][valor_total]"
                                                class="form-control valor-mask-input" placeholder="0,00"
                                                value="{{ old("funcionarios.0.valor_total") }}">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-1">
                                            <!-- botão remover -->
                                            <button type="button" class="btn btn-danger btn-remover">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-1">
                                            <!-- botão adicionar -->
                                            <button type="button" class="btn btn-success btn-adicionar">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="card border-primary mb-3">
                            <div class="card-header text-primary">Produtos</div>
                            <div class="card-body text-primary">
                                @forelse($item->ordemDeServicoProduto as $osp)
                                    <div id="produto-{{ $osp->id}}" class="linha-form row align-items-end">
                                        <input type="hidden" name="produtos[{{ $osp->id }}][id]"
                                            value="{{ old("produtos.{$osp->id}.id", $osp->id) }}">
                                        <input type="hidden" name="produtos[{{ $osp->id }}][produto_id]"
                                            value="{{ old("produtos.{$osp->id}.produto_id", $osp->produto_id) }}">
                                        <div class="form-group col-sm-12 col-md-2">
                                            <label class="form-label">Código de Barras</label>
                                            <input type="text" name="produtos[{{ $osp->id }}][codigo_de_barras]"
                                                class="form-control auto-preenche-produto"
                                                placeholder="Digite para buscar produtos"
                                                value="{{ old("produtos.{$osp->id}.codigo_de_barras", $osp->produto->codigo_de_barras) }}">
                                        </div>
                                        <div class="col-sm-12 col-md-2 form-group">
                                            <label class="form-label">Nome</label>
                                            <div class="dropdown">
                                                <input type="text" name="produtos[{{ $osp->id }}][nome]" class="form-control busca-produtos"
                                                    placeholder="Digite para buscar produtos" 
                                                    value="{{ old("produtos.{$osp->id}.nome", $osp->produto->nome) }}">
                                                <div class="lista-de-produtos dropdown-menu" aria-labelledby="dropdownMenuButton" style="display: none;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-2">
                                            <label class="form-label">Quantidade</label>
                                            <input type="text" name="produtos[{{ $osp->id }}][quantidade]"
                                                class="form-control litros-mask-input atualiza-valores" placeholder="1"
                                                value="{{ old("produtos.{$osp->id}.quantidade", $osp->quantidade) ?? 1 }}" >
                                        </div>
                                        <div class="form-group col-sm-12 col-md-2">
                                            <label class="form-label">Valor Unitário</label>
                                            <input type="text" name="produtos[{{ $osp->id }}][valor_unitario]"
                                                class="form-control valor-mask-input atualiza-valores" placeholder="0,00"
                                                value="{{ old("produtos.{$osp->id}.valor_unitario", $osp->valor_unitario) }}">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-2">
                                            <label class="form-label">Valor Total</label>
                                            <input type="text" name="produtos[{{ $osp->id }}][valor_total]"
                                                class="form-control valor-mask-input" placeholder="0,00"
                                                value="{{ old("produtos.{$osp->id}.valor_total", $osp->valor_total) }}">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-1">
                                            <!-- botão remover -->
                                            <button type="button" class="btn btn-danger btn-remover">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-1">
                                            <!-- botão adicionar -->
                                            <button type="button" class="btn btn-success btn-adicionar">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <div id="produto-1" class="linha-form row align-items-end">
                                        <input type="hidden" name="produtos[0][id]" value="{{ old('id.0') }}">
                                        <input type="hidden" name="produtos[0][produto_id]" value="{{ old('produto_id.0') }}">
                                        <div class="form-group col-sm-12 col-md-2">
                                            <label class="form-label">Código de Barras</label>
                                            <input type="text" name="produtos[0][codigo_de_barras]"
                                                class="form-control auto-preenche-produto"
                                                placeholder="Digite para buscar produtos" value="{{ old('produtos.0.codigo_de_barras') }}">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-2">
                                            <label class="form-label">Nome</label>
                                            <div class="dropdown">
                                                <input type="text" name="produtos[0][nome]" class="form-control busca-produtos"
                                                    placeholder="Digite para buscar produtos" value="{{ old('produtos.0.nome') }}">
                                                <div class="lista-de-produtos dropdown-menu" aria-labelledby="dropdownMenuButton" style="display: none;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-2">
                                            <label class="form-label">Quantidade</label>
                                            <input type="text" name="produtos[0][quantidade]"
                                                class="form-control litros-mask-input atualiza-valores" placeholder="1"
                                                value="{{ old('produtos.0.quantidade') ?? 1 }}" >
                                        </div>
                                        <div class="form-group col-sm-12 col-md-2">
                                            <label class="form-label">Valor Unitário</label>
                                            <input type="text" name="produtos[0][valor_unitario]"
                                                class="form-control valor-mask-input atualiza-valores" placeholder="0,00"
                                                value="{{ old("produtos.0.valor_unitario") }}">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-2">
                                            <label class="form-label">Valor Total</label>
                                            <input type="text" name="produtos[0][valor_total]"
                                                class="form-control valor-mask-input" placeholder="0,00"
                                                value="{{ old("produtos.0.valor_total") }}">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-1">
                                            <!-- botão remover -->
                                            <button type="button" class="btn btn-danger btn-remover" title="Remover">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-1">
                                            <!-- botão adicionar -->
                                            <button type="button" class="btn btn-success btn-adicionar" title="Adicionar">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="card linha-form col-sm-12 col-md-4">
                                <div class="card-header">Troca de Óleo do Motor?</div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input abre-campos btn-check" type="radio" name="troca_oleo_motor" id="nao"
                                                value="0" @if($item->troca_oleo_motor == 0) checked @endif>
                                            <label class="form-check-label" for="nao">Não</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input abre-campos btn-check" type="radio" name="troca_oleo_motor" id="sim"
                                                value="1" @if($item->troca_oleo_motor == 1) checked @endif>
                                            <label class="form-check-label" for="sim">Sim</label>
                                        </div>
                                        <div class="campos-form"
                                            @if($item->troca_oleo_motor == 1) style="display: block;"
                                            @else style="display: none;"
                                            @endif>
                                            <label for="km_oleo_motor">Kilometragem da Troca de Óleo do Motor:</label>
                                            <input type="text" name="km_oleo_motor" id="km_oleo_motor" class="form-control km-mask-input" 
                                                placeholder="0,0" value="{{ old('km_oleo_motor', $item) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card linha-form col-sm-12 col-md-4">
                                <div class="card-header">Troca de Óleo da Caixa?</div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input abre-campos btn-check" type="radio" name="troca_oleo_caixa" id="nao"
                                                value="0" @if($item->troca_oleo_caixa == 0) checked @endif>
                                            <label class="form-check-label" for="nao">Não</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input abre-campos btn-check" type="radio" name="troca_oleo_caixa" id="sim"
                                                value="1" @if($item->troca_oleo_caixa == 1) checked @endif>
                                            <label class="form-check-label" for="sim">Sim</label>
                                        </div>
                                        <div class="campos-form"
                                            @if($item->troca_oleo_caixa == 1) style="display: block;"
                                            @else style="display: none;"
                                            @endif>
                                            <label for="km_oleo_caixa">Kilometragem da Troca de Óleo da Caixa:</label>
                                            <input type="text" name="km_oleo_caixa" id="km_oleo_caixa" class="form-control km-mask-input" 
                                                placeholder="0,0" value="{{ old('km_oleo_caixa', $item) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card linha-form col-sm-12 col-md-4">
                                <div class="card-header">Troca de Óleo do Diferencial?</div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input abre-campos btn-check" type="radio" name="troca_oleo_diferencial" id="nao"
                                                value="0" @if($item->troca_oleo_diferencial == 0) checked @endif>
                                            <label class="form-check-label" for="nao">Não</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input abre-campos btn-check" type="radio" name="troca_oleo_diferencial" id="sim"
                                                value="1" @if($item->troca_oleo_diferencial == 1) checked @endif>
                                            <label class="form-check-label" for="sim">Sim</label>
                                        </div>
                                        <div class="campos-form"
                                            @if($item->troca_oleo_diferencial == 1) style="display: block;"
                                            @else style="display: none;"
                                            @endif>
                                            <label for="km_oleo_diferencial">Kilometragem da Troca de Óleo do Diferencial:</label>
                                            <input type="text" name="km_oleo_diferencial" id="km_oleo_diferencial" class="form-control km-mask-input" 
                                                placeholder="0,0" value="{{ old('km_oleo_diferencial', $item) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-end">
                            <div class="form-group col-sm-12 col-md-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save" aria-hidden="true"></i>
                                    Salvar
                                </button>
                            </div>
                        </div>
                    </form>

                    <br><br>
                    <div class="row">
                        <div class="col-sm-12 col-md-2 form-group">
                            <a href="{{ url('ordens-de-servicos') }}" class="btn btn-info">
                                <i class="fas fa-angle-double-left"></i>
                                Voltar
                            </a>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <form id="form_excluir" action="{{ url('ordens-de-servicos/excluir', $item->id) }}" method="post">
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
            function novaLinhaProduto(novaLinha, novoIndex) {
                // Atualiza os índices dos inputs na nova linha
                novaLinha.find('select[name*="[codigo_de_barras]"]').attr('name', 'produtos[' + novoIndex + '][codigo_de_barras]');
                novaLinha.find('input[name*="[codigo_de_barras]"]').attr('name', 'produtos[' + novoIndex + '][codigo_de_barras]');
                novaLinha.find('input[name^="produtos"][name$="[id]"]').attr('name', 'produtos[' + novoIndex + '][id]');
                novaLinha.find('input[name*="[produto_id]"]').attr('name', 'produtos[' + novoIndex + '][produto_id]');
                novaLinha.find('input[name*="[nome]"]').attr('name', 'produtos[' + novoIndex + '][nome]');
                novaLinha.find('input[name*="[quantidade]"]').attr('name', 'produtos[' + novoIndex + '][quantidade]');
                novaLinha.find('input[name*="[valor_unitario]"]').attr('name', 'produtos[' + novoIndex + '][valor_unitario]');
                novaLinha.find('input[name*="[valor_total]"]').attr('name', 'produtos[' + novoIndex + '][valor_total]');
            }

            function novaLinhaFuncionario(novaLinha, novoIndex) {
                // Atualiza os índices dos inputs na nova linha
                novaLinha.find('select[name*="[funcionario_id]"]').attr('name', 'funcionarios[' + novoIndex + '][funcionario_id]');
                novaLinha.find('input[name^="funcionarios"][name$="[id]"]').attr('name', 'funcionarios[' + novoIndex + '][id]');
                novaLinha.find('input[name*="[tempo]"]').attr('name', 'funcionarios[' + novoIndex + '][tempo]');
                novaLinha.find('input[name*="[valor_unitario]"]').attr('name', 'funcionarios[' + novoIndex + '][valor_unitario]');
                novaLinha.find('input[name*="[valor_total]"]').attr('name', 'funcionarios[' + novoIndex + '][valor_total]');
            }

            $(document).ready(function() {
                // transfere a colection de produtos para o jquery
                var produtos = @json($produtos);
                // transfere a colection de funcionarios para o jquery
                var funcionarios = @json($funcionarios);
                // quantidade de horas para trabalho
                var horas_trabalho = @json($horas_trabalho);

                // Adiciona uma nova linha ao clicar no botão de adicionar
                $(document).on("click", ".btn-adicionar", function() {
                    var ultimaLinha = $(this).closest(".card-body").find(".linha-form:last");
                    var novaLinha = ultimaLinha.clone();
                    // Limpa os valores dos campos
                    novaLinha.find("select, input").val("");

                    // Incrementa o ID da nova linha
                    var novoIndex = (parseInt(ultimaLinha.attr("id").split("-")[1]) + 1);

                    if (ultimaLinha.attr("id").startsWith("produto")) {
                        var novoId = "produto-" + novoIndex;
                        novaLinhaProduto(novaLinha, novoIndex);
                    } else {                    
                        var novoId = "funcionario-" + novoIndex;
                        novaLinhaFuncionario(novaLinha, novoIndex);
                    }

                    // ajusta o id da nova linha
                    novaLinha.attr("id", novoId);

                    // Adiciona a nova linha após a última linha
                    ultimaLinha.after(novaLinha);
                });

                // Remove a linha ao clicar no botão de remover
                $(document).on("click", ".btn-remover", function() {
                    $(this).closest(".linha-form").remove();
                });
            
                // Quando preencher o código de barras
                $(document).on("change", ".auto-preenche-produto", function () {

                    // Pega o valor inserido
                    var linha = $(this).closest(".linha-form");
                    var itemSelecionado = this.value;
                    quantidade = linha.find("input[name*='quantidade']").val();

                    // limpa valores da nova linha antes de preencher
                    linha.find("select, input").val("");

                    // retorna o valor da quantidade anteriormente
                    linha.find("input[name*='quantidade']").val(quantidade);

                    // Encontrar o produto correspondente na lista de produtos
                    var produtoEncontrado = produtos.find(function (produto) {
                        return produto.codigo_de_barras === itemSelecionado;
                    });

                    // Preencher o id e o nome do produto se ele foi encontrado
                    if (produtoEncontrado) {
                        linha.find("input[name*='produto_id']").val(produtoEncontrado.id);
                        linha.find("input[name*='nome']").val(produtoEncontrado.nome);
                        linha.find("input[name*='codigo_de_barras']").val(produtoEncontrado.codigo_de_barras);
                        linha.find("input[name*='valor_unitario']").val(produtoEncontrado.valor_unitario);
                        
                        // recria a mascara
                        linha.find("input[name*='valor_unitario']").unmask();
                        linha.find("input[name*='valor_unitario']").mask('#.##0,00', { reverse: true });
                        
                        // dispara envento de change na quantidade
                        linha.find("input[name*='quantidade']").trigger('change');              
                    }

                });

                // Quando selecionar o funcionário
                $(document).on("change", ".auto-preenche-funcionario", function () {
                    // Pega o valor inserido
                    var linha = $(this).closest(".linha-form");
                    var itemSelecionado = this.value;
                    tempo = linha.find("input[name*='tempo']").val();

                    // Encontrar o produto correspondente na lista de produtos
                    var funcionariosEncontrado = funcionarios.find(function (funcionario) {
                        return String(funcionario.id) === String(itemSelecionado);
                    });

                    // Preencher o id e o nome do produto se ele foi encontrado
                    if (funcionariosEncontrado) {    
                        var salarioPorHora = funcionariosEncontrado.salario / horas_trabalho;            
                        linha.find("input[name*='valor_unitario']").val(salarioPorHora.toFixed(2).replace('.', ','));
                        
                        // recria a mascara
                        linha.find("input[name*='valor_unitario']").unmask();
                        linha.find("input[name*='valor_unitario']").mask('#.##0,00', { reverse: true });
                        
                        // dispara envento de change na quantidade
                        linha.find("input[name*='tempo']").trigger('change');
                    }
                });

                // Quando houver uma mudança nos campos com classe 'atualiza-valores'
                $(document).on("change", ".atualiza-valores", function () {                
                    // Obtendo os valores inseridos
                    var linha = $(this).closest(".linha-form");
                    var quantidade = 0;
                    var valor_unitario = parseFloat(linha.find("input[name*='valor_unitario']").val().replace(".", "").replace(",", "."));
                    
                    // se for funcionario usario o tempo para calcular
                    if (linha.attr("id").startsWith("funcionario")) {
                        quantidade = parseFloat(linha.find("input[name*='tempo']").val().replace(".", "").replace(",", "."));
                    } else {
                        quantidade = parseFloat(linha.find("input[name*='quantidade']").val().replace(".", "").replace(",", "."));
                    }

                    // Verificando se os valores são números válidos
                    if (!isNaN(quantidade) && !isNaN(valor_unitario)) {
                        var valor_total = valor_unitario * quantidade;                    
                        // Definindo o valor calculado no campo 'valor_total'
                        linha.find("input[name*='valor_total']").val(valor_total.toFixed(2).replace('.', ',')); // Formatando para usar vírgula como separador decimal
                    } else {
                        console.log('Valores inválidos');
                    }
                    
                    // Reaplicando a máscara para valor_unitario
                    linha.find("input[name*='valor_unitario']").unmask().mask('#.##0,00', { reverse: true });
                });

                $(document).on("input", ".busca-produtos", function () {
                    let termo = $(this).val();
                    let linha = $(this).closest(".linha-form");
                    let opcoesProdutos = linha.find(".lista-de-produtos");
                    let inputCodigoDeBarras = linha.find("input[name*='codigo_de_barras']");

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
                        $('.lista-de-produtos').hide();
                    }
                });

            });
        </script>
@endpush
