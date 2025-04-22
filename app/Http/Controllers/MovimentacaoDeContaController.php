<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovimentacaoDeContaRequest;
use App\Http\Services\BaseService;
use App\Models\Cliente;
use App\Models\Conta;
use App\Models\Fornecedor;
use App\Models\MovimentacaoDeConta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovimentacaoDeContaController extends Controller
{
    protected MovimentacaoDeConta $model;
    
    const VIEW_NAME = 'movimentacoes';

    public function __construct(MovimentacaoDeConta $movimentacao)
    {
        $this->model = $movimentacao;
    }

    /**
     * abre tela de listagem das MovimentacaoDeContas
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        if(!$request->filtro_competencia) {
            $request->offsetSet('filtro_competencia', now()->format('Ym'));
        }

        $collection = $this->model->select(
                        'movimentacao_de_contas.*',
                        'contas.descricao as conta',
                        'clientes.descricao as cliente',
                        'fornecedores.descricao as fornecedor'
                    )
                    ->join('contas', 'contas.id', 'movimentacao_de_contas.conta_id')
                    ->leftJoin('clientes', 'clientes.id', 'movimentacao_de_contas.cliente_id')
                    ->leftJoin('fornecedores', 'fornecedores.id', 'movimentacao_de_contas.fornecedor_id')
                    ->when($request->filtro_competencia > 0, function ($query) use ($request) {
                        return $query->where(DB::RAW("date_format(pagamento, '%Y%m')"), $request->filtro_competencia);
                    })
                    ->when($request->filtro_data, function ($query) use ($request) {
                        return $query->where('movimentacao_de_contas.pagamento', $request->filtro_data);
                    })
                    ->when($request->filtro_conta, function ($query) use ($request) {
                        return $query->where('contas.descricao', 'LIKE', '%' . $request->filtro_conta . '%');
                    })
                    ->when($request->filtro_movimentacao > 0, function ($query) use ($request) {
                        return $query->where('movimentacao_de_contas.tipo_de_movimentacao', $request->filtro_movimentacao);
                    })
                    ->orderBy('pagamento', 'DESC')
                    ->orderBy('contas.descricao', 'ASC')
                    ->get();
        
        $competences = $this->model->competences();
        $movimentacoes = $this->model::TIPO_MOVIMENTACAO;

        return view(self::VIEW_NAME.'.index', compact('collection', 'request', 'competences', 'movimentacoes'));
    }

    /**
     * abre tela de gráfico das MovimentacaoDeContas
     *
     * @param Request $request
     * @return void
     */
    public function dashboard(Request $request)
    {
        return view(self::VIEW_NAME.'.dashboard');
    }

    /**
     * abre tela de edição / cadastro da MovimentacaoDeConta
     *
     * @param MovimentacaoDeConta $movimentacao
     * @return void
     */
    public function edit(Request $request, $id = null)
    {
        if ($id === 'entrada' || $id === 'saida') {
            $movimentacao = new MovimentacaoDeConta();
            
            if ($id === 'entrada') {
                $movimentacao->tipo_de_movimentacao = MovimentacaoDeConta::ENTRADA;
            } elseif ($id === 'saida') {
                $movimentacao->tipo_de_movimentacao = MovimentacaoDeConta::SAIDA;
            }
        } else {
            // Se $id não for uma string 'Entrada' ou 'Saida', assume-se que seja o ID da movimentação
            $movimentacao = MovimentacaoDeConta::findOrFail($id);
        }

        $contas = Conta::orderBy('descricao')->get();
        $clientes = Cliente::orderBy('descricao')->get();
        $fornecedores = Fornecedor::orderBy('descricao')->get();

        return view(self::VIEW_NAME.'.edit', [
            'item' => $movimentacao,
            'contas' => $contas,
            'clientes' => $clientes,
            'fornecedores' => $fornecedores,
            'request' => $request
        ]);
    }

    /**
     * salva os dados da MovimentacaoDeConta
     *
     * @param StoreMovimentacaoDeContaRequest $request
     * @param MovimentacaoDeConta $movimentacao
     * @return void
     */
    public function store(StoreMovimentacaoDeContaRequest $request, MovimentacaoDeConta $movimentacao)
    {
        $data = $request->only('pagamento', 'tipo_de_movimentacao', 'conta_id', 'cliente_id', 'fornecedor_id', 'motivo', 'tipo_pagamento');
        $data['valor'] = BaseService::convertStringToFloat($request->valor);
        $data['user_id'] = auth()->id();
        
        // reverte o saldo anterior
        if ($movimentacao->id && $movimentacao->conta_id) {
            $conta = Conta::find($movimentacao->conta_id);
            $conta->data_atualizacao = now()->format('Y-m-d');
            $novo_saldo = $conta->saldo + $movimentacao->valor;
            if ($movimentacao->tipo_de_movimentacao == $movimentacao::ENTRADA) {
                $novo_saldo = $conta->saldo - $movimentacao->valor ;
            }
            $conta->saldo = $novo_saldo;
            if (!$conta->save()) {
                return $this->responseError();
            }
        }
        
        // aplica novo saldo
        $conta = Conta::find($request->conta_id);
        $conta->data_atualizacao = now()->format('Y-m-d');
        $novo_saldo = $conta->saldo + $data['valor'];
        if ($request->tipo_de_movimentacao == $movimentacao::SAIDA) {
            $novo_saldo = $conta->saldo - $data['valor'] ;
        }
        $conta->saldo = $novo_saldo;

        if (!$conta->save()) {
            return $this->responseError();
        }
    
        $movimentacao->fill($data);
        if (!$movimentacao->save()) {
            return $this->responseError();
        }

        // salvar arquivo de pdf
        if ($request->hasFile('arquivo_pdf')) {
            $file = $request->file('arquivo_pdf');
            // Define o nome do arquivo
            $fileName = '[' . $movimentacao->id . '] [' . time() . '] ' . $file->getClientOriginalName();
            // Salva o arquivo no armazenamento
            $path = $file->storeAs('movimentacoes', $fileName, 'public');
            // Adiciona o caminho do arquivo à sua entrada de dados
            $movimentacao->fill(['caminho_arquivo_pdf' => $path]);
            $movimentacao->save();
        }

        return redirect(self::VIEW_NAME . '?' . $request->getQueryString())->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * exlui a MovimentacaoDeConta
     *
     * @param MovimentacaoDeConta $movimentacao
     * @return void
     */
    public function destroy(Request $request, MovimentacaoDeConta $movimentacao)
    {
        // reverte saldo anterior
        $conta =  Conta::find($movimentacao->conta_id);
        $conta->data_atualizacao = now()->format('Y-m-d');
        $novo_saldo = $conta->saldo + $movimentacao->valor;
        if ($movimentacao->tipo_de_movimentacao == $movimentacao::ENTRADA) {
            $novo_saldo = $conta->saldo - $movimentacao->valor;
        }
        $conta->saldo = $novo_saldo;
        
        if (!$conta->save()) {
            return $this->responseError();
        }

        if (!$movimentacao->delete()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME . '?' . $request->getQueryString())->with('success', self::MESSAGE_SUCCESS);
    }

    public function diarias()
    {
        // Montando a consulta
        $movimentacoes = MovimentacaoDeConta::selectRaw('
            pagamento AS date,
            SUM(CASE WHEN tipo_de_movimentacao = "1" THEN valor ELSE 0 END) as total_entrada,
            SUM(CASE WHEN tipo_de_movimentacao = "2" THEN valor ELSE 0 END) as total_saida,
            SUM(CASE WHEN tipo_de_movimentacao = "1" AND tipo_pagamento = "Boleto" THEN valor ELSE 0 END) as total_entrada_boleto,
            SUM(CASE WHEN tipo_de_movimentacao = "1" AND tipo_pagamento = "Dinheiro" THEN valor ELSE 0 END) as total_entrada_dinheiro,
            SUM(CASE WHEN tipo_de_movimentacao = "1" AND tipo_pagamento = "Cheque" THEN valor ELSE 0 END) as total_entrada_cheque,
            SUM(CASE WHEN tipo_de_movimentacao = "1" AND tipo_pagamento = "Pix" THEN valor ELSE 0 END) as total_entrada_pix,
            SUM(CASE WHEN tipo_de_movimentacao = "1" AND tipo_pagamento = "Débito em Conta" THEN valor ELSE 0 END) as total_entrada_debito,
            SUM(CASE WHEN tipo_de_movimentacao = "1" AND tipo_pagamento IS NULL THEN valor ELSE 0 END) as total_entrada_indefinido,
            SUM(CASE WHEN tipo_de_movimentacao = "2" AND tipo_pagamento = "Boleto" THEN valor ELSE 0 END) as total_saida_boleto,
            SUM(CASE WHEN tipo_de_movimentacao = "2" AND tipo_pagamento = "Dinheiro" THEN valor ELSE 0 END) as total_saida_dinheiro,
            SUM(CASE WHEN tipo_de_movimentacao = "2" AND tipo_pagamento = "Cheque" THEN valor ELSE 0 END) as total_saida_cheque,
            SUM(CASE WHEN tipo_de_movimentacao = "2" AND tipo_pagamento = "Pix" THEN valor ELSE 0 END) as total_saida_pix,
            SUM(CASE WHEN tipo_de_movimentacao = "2" AND tipo_pagamento = "Débito em Conta" THEN valor ELSE 0 END) as total_saida_debito,
            SUM(CASE WHEN tipo_de_movimentacao = "2" AND tipo_pagamento IS NULL THEN valor ELSE 0 END) as total_saida_indefinido
        ')
        ->groupBy('date')
        ->orderBy('date', 'desc')
        ->get();

        // boletos pagos apenas para o perfil de gestor de contas
        $boletosPagos = DB::table('boletos')
                            ->join('users', 'boletos.user_id', '=', 'users.id')
                            ->selectRaw('
                                DATE(vencimento) AS date,
                                SUM(valor) as total_boletos_pago
                            ')
                            ->where('users.tipo_usuario', User::CONTAS)
                            ->where('boletos.pago', 1)
                            ->groupBy(DB::raw('DATE(vencimento)'))
                            ->orderBy('date')
                            ->get();
        
        // instancia resultados
        $resultados =  [];

        // Adiciona movimentações ao array de resultados
        foreach ($movimentacoes as $movimentacao) {
            $resultados[$movimentacao->date] = [
                'date' => $movimentacao->date,
                'total_entrada' => $movimentacao->total_entrada,
                'total_saida' => $movimentacao->total_saida,
                'total_entrada_boleto' => $movimentacao->total_entrada_boleto,
                'total_entrada_dinheiro' => $movimentacao->total_entrada_dinheiro,
                'total_entrada_cheque' => $movimentacao->total_entrada_cheque,
                'total_entrada_pix' => $movimentacao->total_entrada_pix,
                'total_entrada_debito' => $movimentacao->total_entrada_debito,
                'total_entrada_indefinido' => $movimentacao->total_entrada_indefinido,
                'total_saida_boleto' => $movimentacao->total_saida_boleto,
                'total_saida_dinheiro' => $movimentacao->total_saida_dinheiro,
                'total_saida_cheque' => $movimentacao->total_saida_cheque,
                'total_saida_pix' => $movimentacao->total_saida_pix,
                'total_saida_debito' => $movimentacao->total_saida_debito,
                'total_saida_indefinido' => $movimentacao->total_saida_indefinido,
                'total_boletos_pago' => 0,
            ];
        }

        // Adiciona boletos pagos ao array de resultados
        foreach ($boletosPagos as $boleto) {
            if (isset($resultados[$boleto->date])) {
                $resultados[$boleto->date]['total_boletos_pago'] = $boleto->total_boletos_pago;
            } else {
                $resultados[$boleto->date] = [
                    'date' => $boleto->date,
                    'total_entrada' => 0,
                    'total_saida' => 0,
                    'total_entrada_boleto' => 0,
                    'total_entrada_dinheiro' => 0,
                    'total_entrada_cheque' => 0,
                    'total_entrada_pix' => 0,
                    'total_entrada_debito' => 0,
                    'total_entrada_indefinido' => 0,
                    'total_saida_boleto' => 0,
                    'total_saida_dinheiro' => 0,
                    'total_saida_cheque' => 0,
                    'total_saida_pix' => 0,
                    'total_saida_debito' => 0,
                    'total_saida_indefinido' => 0,
                    'total_boletos_pago' => $boleto->total_boletos_pago,
                ];
            }            
        }

        // Usa krsort para ordenar o array pelas chaves (datas) em ordem decrescente
        krsort($resultados);
        
        return view('movimentacoes.diarias', compact('resultados'));
    }
}
