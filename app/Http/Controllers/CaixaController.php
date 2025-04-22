<?php

namespace App\Http\Controllers;

use App\Models\Caixa;
use App\Http\Requests\StoreCaixaRequest;
use App\Http\Services\BaseService;
use App\Models\Frete;
use App\Models\Local;
use App\Models\MovimentacaoDeCaixa;
use Illuminate\Http\Request;

class CaixaController extends Controller
{
    protected Caixa $model;
    
    const VIEW_NAME = 'caixas';

    public function __construct(Caixa $caixa)
    {
        $this->model = $caixa;
    }

    /**
     * abre tela de listagem dos caixas
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $collection = $this->model->with(['local', 'movimentacaoDeCaixa'])->get();

        return view(self::VIEW_NAME.'.index', compact('collection'));
    }

    /**
     * abre tela de edição / cadastro do caixa
     *
     * @param Caixa $caixa
     * @return void
     */
    public function edit(Caixa $caixa)
    {
        // $movimentacoes = $caixa->movimentacaoDeCaixa()->pluck('id')->toArray();

        $locais = Local::orderBy('nome')->get();

        // LOG NÃO UTILIZADO
        // $logs = Log::where('tabela', 'movimentacao_de_caixas')
        //             ->whereIn('tabela_id', $movimentacoes)
        //             ->latest()
        //             ->paginate(50);

        return view(self::VIEW_NAME.'.edit', ['item' => $caixa, 'locais' => $locais]);
    }

    /**
     * adiciona saldo do caixa
     *
     * @param Caixa $caixa
     * @return view
     */
    public function add(Caixa $caixa)
    {
        $cargas = Frete::where('local_origem_id', $caixa->local_id)->get();

        return view(self::VIEW_NAME.'.add', ['item' => $caixa, 'cargas' => $cargas]);
    }

    /**
     * retira saldo do caixa
     *
     * @param Caixa $caixa
     * @return view
     */
    public function withdraw(Caixa $caixa)
    {
        return view(self::VIEW_NAME.'.withdraw', ['item' => $caixa]);
    }

    /**
     * salva os dados do caixa
     *
     * @param StoreCaixaRequest $request
     * @param Caixa $caixa
     * @return void
     */
    public function store(StoreCaixaRequest $request, Caixa $caixa)
    {
        // cadastro de movimentação de caixa
        if ($request->caixa_id) {
            $data = $request->only('caixa_id', 'tipo_de_movimentacao', 'frete_id',
                                    'data_movimentacao', 'motivo');
            $data['valor'] = BaseService::convertStringToFloat($request->valor);
            $data['user_id'] = auth()->id();

            $saldo = $caixa->saldo + $data['valor'];
            if ($request->tipo_de_movimentacao == $caixa::SAIDA) {
                $saldo = $caixa->saldo - $data['valor'] ;
            }
            
            $caixa->fill([
                'data_atualizacao' => $request->data,
                'saldo' => $saldo
            ]);

            if (!$caixa->save()) {
                return $this->responseError();
            }

            $movimentacaoDeCaixa = new MovimentacaoDeCaixa();
            $movimentacaoDeCaixa->fill($data);
            if (!$movimentacaoDeCaixa->save()) {
                return $this->responseError();
            }
        }
        // cadastro de caixa
        else {
            $data = $request->only('local_id', 'data_atualizacao');
        
            $data['saldo'] = BaseService::convertStringToFloat($request->saldo);

            $caixa->fill($data);

            if (!$caixa->save()) {
                return $this->responseError();
            }
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * exlui o caixa
     *
     * @param Caixa $caixa
     * @return void
     */
    public function destroy(Caixa $caixa)
    {
        if (!$caixa->delete()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }
}
