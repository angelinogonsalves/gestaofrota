<?php

namespace App\Http\Controllers;

use App\Models\OrdemDeServico;
use App\Http\Requests\StoreOrdemDeServicoRequest;
use App\Http\Services\BaseService;
use App\Models\Funcionario;
use App\Models\OrdemDeServicoFuncionario;
use App\Models\OrdemDeServicoProduto;
use App\Models\Produto;
use App\Models\TipoDespesa;
use App\Models\Veiculo;
use Illuminate\Http\Request;

class OrdemDeServicoController extends Controller
{
    protected OrdemDeServico $model;
    
    const VIEW_NAME = 'ordens-de-servicos';

    public function __construct(OrdemDeServico $ordemDeServico)
    {
        $this->model = $ordemDeServico;
    }

    /**
     * abre tela de listagem das manutenções
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $collection = $this->model->with(['ordemDeServicoProduto', 'ordemDeServicoFuncionario', 'veiculo'])->get();

        return view(self::VIEW_NAME.'.index', compact('collection'));
    }

    /**
     * abre tela de edição / cadastro da manutenção
     *
     * @param OrdemDeServico $ordemDeServico
     * @return void
     */
    public function edit(OrdemDeServico $ordemDeServico)
    {
        $veiculos = Veiculo::orderBy('placa')->get();
        $funcionarios = Funcionario::orderBy('nome')->get();
        $produtos = Produto::orderBy('nome')->get();

        return view(self::VIEW_NAME.'.edit', [
            'item' => $ordemDeServico,
            'veiculos' => $veiculos,
            'funcionarios' => $funcionarios,
            'produtos' => $produtos,
            'horas_trabalho' => TipoDespesa::HORAS_TRABALHO
        ]);
    }

    /**
     * salva os dados da manutenção
     *
     * @param StoreOrdemDeServicoRequest $request
     * @param OrdemDeServico $ordemDeServico
     * @return void
     */
    public function store(StoreOrdemDeServicoRequest $request, OrdemDeServico $ordemDeServico)
    {
        /** SALVA MANUTENÇÃO */
        
        // seta variável para salvar os dados para atualizar o veículo
        $dataVeiculo = [];
        // seta variável com os valores para atualizar ou criar a ordem de serviço - manutenção
        $data = $request->only('data_solicitacao', 'veiculo_id', 'problema', 'data_inicio', 'data_fim', 'solucao', 'observacao');
        
        // atualiza e calcula a troca de óleo do motor
        $data['troca_oleo_motor'] = $request->troca_oleo_motor;
        $data['km_oleo_motor'] = null;
        if ($request->troca_oleo_motor && $request->km_oleo_motor) {
            $data['km_oleo_motor'] = BaseService::convertStringToFloat($request->km_oleo_motor);
            $dataVeiculo['km_prox_motor'] = $data['km_oleo_motor'] + Veiculo::proxTrocaOleoMotor($request->veiculo_id);
        }
        
        // atualiza e calcula a troca de óleo da caixa
        $data['troca_oleo_caixa'] = $request->troca_oleo_caixa;
        $data['km_oleo_caixa'] = null;
        if ($request->troca_oleo_caixa && $request->km_oleo_caixa) {
            $data['km_oleo_caixa'] = BaseService::convertStringToFloat($request->km_oleo_caixa);
            $dataVeiculo['km_prox_motor'] = $data['km_oleo_caixa'] + Veiculo::proxTrocaOleoCaixa($request->veiculo_id);
        }
        
        // atualiza e calcula a troca de óleo do diferencial
        $data['troca_oleo_diferencial'] = $request->troca_oleo_diferencial;
        $data['km_oleo_diferencial'] = null;
        if ($request->troca_oleo_diferencial && $request->km_oleo_diferencial) {
            $data['km_oleo_diferencial'] = BaseService::convertStringToFloat($request->km_oleo_diferencial);
            $dataVeiculo['km_prox_motor'] = $data['km_oleo_diferencial'] + Veiculo::proxTrocaOleoDiferencial($request->veiculo_id);
        }
        
        // injeta os dados na ordem de serviço
        $ordemDeServico->fill($data);
        // salva a ordem de serviço
        if (!$ordemDeServico->save()) {
            return $this->responseError();
        }


        /** SALVA FUNCIONARIOS */

        // Encontra os funcionários
        $funcionarios = $request->input('funcionarios');
        
        // Extrair os valores da coluna 'funcionario_id'
        $funcionarioIds = array_column(array_filter($funcionarios, function ($value) {
            return isset($value["funcionario_id"]);
        }), "funcionario_id");
        
        // caso existam funcionários irá salvar eles
        if (!empty($funcionarioIds)) {
            
            // Remove os funcionários que não estão presentes no array do request
            $ordemDeServico->ordemDeServicoFuncionario()
                ->whereNotIn('funcionario_id', $funcionarioIds)
                ->delete();

            // Itera sobre os funcionários fornecidos no request
            foreach ($funcionarios as $funcionarioData) {
                
                // Obtém o funcionário ou cria um novo se o ID não estiver presente
                if (isset($funcionarioData['id'])) {
                    $funcionario = OrdemDeServicoFuncionario::find($funcionarioData['id']);
                } else {
                    $funcionario = new OrdemDeServicoFuncionario();
                }
                
                // Define os atributos do funcionário
                if (isset($funcionarioData['funcionario_id'])) {
                    $funcionario->fill([
                        'ordem_de_servico_id' => $ordemDeServico->id,
                        'funcionario_id' => $funcionarioData['funcionario_id'],
                        'tempo' => BaseService::convertStringToFloat($funcionarioData['tempo']),
                        'valor_unitario' => BaseService::convertStringToFloat($funcionarioData['valor_unitario']),
                        'valor_total' => BaseService::convertStringToFloat($funcionarioData['valor_total']),
                    ]);
                    // Salva o funcionário associado à ordem de serviço
                    $funcionario->save();
                }
            }
        }


        /** SALVA PRODUTOS */

        // Encontra os produtos
        $produtos = $request->input('produtos');

        // Extrair os valores da coluna 'funcionario_id'
        $produtoIds = array_column(array_filter($produtos, function ($value) {
            return isset($value["produto_id"]);
        }), "produto_id");

        // caso existam produtos irá salvar eles
        if (!empty($produtoIds)) {

            // Remove os funcionários que não estão presentes no array do request
            $ordemDeServico->ordemDeServicoProduto()
                ->whereNotIn('produto_id', $produtoIds)
                ->delete();

            // Itera sobre os produtos fornecidos no request
            foreach ($produtos as $produtoData) {
                
                // Obtém o produto ou cria um novo se o ID não estiver presente
                if (isset($produtoData['id'])) {
                    $produto = OrdemDeServicoProduto::find($produtoData['id']);
                } else {
                    $produto = new OrdemDeServicoProduto();
                }
                
                // Define os atributos do produto
                if (isset($produtoData['produto_id'])) {
                    $produto->fill([
                        'ordem_de_servico_id' => $ordemDeServico->id,
                        'produto_id' => $produtoData['produto_id'],
                        'quantidade' => BaseService::convertStringToFloat($produtoData['quantidade']),
                        'valor_unitario' => BaseService::convertStringToFloat($produtoData['valor_unitario']),
                        'valor_total' => BaseService::convertStringToFloat($produtoData['valor_total']),
                    ]);
                    // Salva o produto associado à ordem de serviço
                    $produto->save();
                }
            }
        }

        /** ATUALIZA VALOR DE MÃO DE OBRA */
        $valorMaoDeObra = $ordemDeServico->ordemDeServicoFuncionario()->sum('valor_total');
        $ordemDeServico->valor_mao_de_obra = $valorMaoDeObra;

        /** ATUALIZA VALOR DE PRODUTOS */
        $valorProdutos = $ordemDeServico->ordemDeServicoProduto()->sum('valor_total');
        $ordemDeServico->valor_produtos = $valorProdutos;

        /** Soma valores */
        $ordemDeServico->valor_total = $valorMaoDeObra + $valorProdutos;

        // Salva a ordem de serviço com os valores atualizados
        $ordemDeServico->save();

        /** SALVA VEICULO */

        // se houver dados do veículo irá atualizar ele
        if (!empty($dataVeiculo)) {

            // encontra o veículo pelo id da ordem de serviço, é obrigatório existir
            $veiculo = Veiculo::find($ordemDeServico->veiculo_id);
            // injeta os dados do veículo
            $veiculo->fill($dataVeiculo);
            // salva as informações do veículo
            $veiculo->save();
        }

        // retorna com a mensagem de sucesso
        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * exlui a manutenção
     *
     * @param OrdemDeServico $ordemDeServico
     * @return void
     */
    public function destroy(OrdemDeServico $ordemDeServico)
    {
        if (!$ordemDeServico->delete()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }
}
