<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Http\Requests\StoreProdutoRequest;
use App\Http\Services\BaseService;
use App\Models\MovimentacaoDeProduto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    protected Produto $model;
    
    const VIEW_NAME = 'produtos';

    public function __construct(Produto $produto)
    {
        $this->model = $produto;
    }

    /**
     * abre tela de listagem dos produtos
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $collection = $this->model->with(['movimentacaoDeProduto'])->get();

        return view(self::VIEW_NAME.'.index', compact('collection'));
    }

    /**
     * abre tela de edição / cadastro do produto
     *
     * @param Produto $produto
     * @return void
     */
    public function edit(Produto $produto)
    {
        return view(self::VIEW_NAME.'.edit', ['item' => $produto]);
    }

    /**
     * adiciona estoque do produto
     *
     * @return view
     */
    public function add()
    {
        $produtos = Produto::all();

        return view(self::VIEW_NAME.'.add', ['produtos' => $produtos]);
    }

    /**
     * retira estoque do produto
     *
     * @return view
     */
    public function withdraw()
    {
        $produtos = Produto::all();

        return view(self::VIEW_NAME.'.withdraw', ['produtos' => $produtos]);
    }

    /**
     * salva os dados do produto
     *
     * @param StoreProdutoRequest $request
     * @param Produto $produto
     * @return void
     */
    public function store(StoreProdutoRequest $request, Produto $produto)
    {
        // adicionando estoque
        if ($request->tipo_de_movimentacao == $produto::ENTRADA) {
            // quantidade adicionada ao estoque, somando com o existente
            $quantidade_adicionada = BaseService::convertStringToFloat($request->quantidade);
            $quantidade_em_estoque = $produto->quantidade_em_estoque + $quantidade_adicionada;
            // valor total adicionado somando ao existente
            $valor_total_adicionado = BaseService::convertStringToFloat($request->valor_total);
            $valor_total = $produto->valor_total + $valor_total_adicionado;
            // valor unitario adicionado, calculando com a divisão e pegando a média
            $valor_unitario_adicionado = $valor_total_adicionado / $quantidade_adicionada;
            $valor_unitario = ($produto->valor_unitario + $valor_unitario_adicionado) / 2;
            // insere os valores ao produto
            $produto->fill([
                'quantidade_em_estoque' => $quantidade_em_estoque,
                'valor_total' => $valor_total,
                'valor_unitario' => $valor_unitario,
                'data_atualizacao' => $request->data_atualizacao,
            ]);
            // salva o produto
            if (!$produto->save()) {
                return $this->responseError();
            }
            // cria a movimentação do estoque
            $movimentacaoDeProduto = new MovimentacaoDeProduto();
            // insere os valores novos
            $movimentacaoDeProduto->fill([
                'tipo_de_movimentacao' => $request->tipo_de_movimentacao,
                'quantidade' => $quantidade_adicionada,
                'valor_total' => $valor_total_adicionado,
                'valor_unitario' => $valor_unitario_adicionado,
                'data_atualizacao' => $request->data_atualizacao,
                'produto_id' => $produto->id,
                'user_id' => auth()->id(),
            ]);
            // salva a movimentação
            if (!$movimentacaoDeProduto->save()) {
                return $this->responseError();
            }
            // retorna para tela de adicionar estoque
            return $this->add()->with('success', self::MESSAGE_SUCCESS);
        }
        // retirando estoque
        elseif ($request->tipo_de_movimentacao == $produto::SAIDA) {
            // quantidade retirada de produtos, subtraindo do estoque atual
            $quantidade_retirada = BaseService::convertStringToFloat($request->quantidade);
            $quantidade_em_estoque = $produto->quantidade_em_estoque - $quantidade_retirada;
            // valor total atualizado com base no que foi retirado
            $valor_total = $produto->valor_total - ($produto->valor_unitario * $quantidade_retirada);
            // insere os novos valores ao produto
            $produto->fill([
                'quantidade_em_estoque'=> $quantidade_em_estoque,
                'valor_total'=> $valor_total,
                'data_atualizacao'=> $request->data_atualizacao,
            ]);
            // salva o produto
            if (!$produto->save()) {
                return $this->responseError();
            }
            // cria a movimentação de estoque
            $movimentacaoDeProduto = new MovimentacaoDeProduto();
            // insere os valores a movimentação de estoque, pega valores do produto e a quantidade informada
            $movimentacaoDeProduto->fill([
                'tipo_de_movimentacao' => $request->tipo_de_movimentacao,
                'quantidade' => $quantidade_retirada,
                'valor_total' => $produto->valor_total,
                'valor_unitario' => $produto->valor_unitario,
                'data_atualizacao' => $request->data_atualizacao,
                'produto_id' => $produto->id,
                'user_id' => auth()->id(),
                'responsavel_retirada' => $request->responsavel_retirada,
                'responsavel_recebimento' => $request->responsavel_recebimento,
            ]);
            // salva a movimentação do estoque
            if (!$movimentacaoDeProduto->save()) {
                return $this->responseError();
            }
            // retorna para tela de retirar estoque
            return $this->withdraw()->with('success', self::MESSAGE_SUCCESS);
        }
        // caso seja a adição de novo produto ou edição do mesmo
        else {
            // valores sem tratamento
            $data = $request->only('nome', 'codigo_de_barras', 'unidade_de_medida', 'data_atualizacao');
            // valores que precisam remover os caracteres
            $data['quantidade_em_estoque'] = BaseService::convertStringToFloat($request->quantidade_em_estoque);
            $data['valor_unitario'] = BaseService::convertStringToFloat($request->valor_unitario);
            $data['valor_total'] = BaseService::convertStringToFloat($request->valor_total);
            // caso venha valor unitario e precise calcular o valor total
            if ($data['valor_unitario'] && $data['quantidade_em_estoque'] && !$data['valor_total']) {
                $data['valor_total'] = $data['valor_unitario'] * $data['quantidade_em_estoque'];
            }
            // caso venha valor total e precise calcula o valor unitário
            elseif (!$data['valor_unitario'] && $data['quantidade_em_estoque'] && $data['valor_total']) {
                $data['valor_unitario'] = $data['valor_total'] / $data['quantidade_em_estoque'];
            }
            // insere os dados no produto
            $produto->fill($data);
            // salva o produto
            if (!$produto->save()) {
                return $this->responseError();
            }
        }
        // redireciona para a tela que estava
        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * exlui o produto
     *
     * @param Produto $produto
     * @return void
     */
    public function destroy(Produto $produto)
    {
        if (!$produto->delete()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * busca o produto por nome ou código de barras
     *
     * @param Request $request
     * @return json $produtos
     */
    public function buscarProdutos(Request $request)
    {
        $termo = $request->input('termo');
        $produtos = Produto::where('nome', 'like', '%'.$termo.'%')
                            // ->orWhere('codigo_de_barras', 'like', '%'.$termo.'%')
                            ->orderBy('nome')
                            ->limit(10)
                            ->get();

        return response()->json($produtos);
    }
}
