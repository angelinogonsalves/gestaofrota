<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use App\Http\Requests\StoreDespesaRequest;
use App\Http\Services\BaseService;
use App\Models\Funcionario;
use App\Models\TipoDespesa;
use App\Models\Veiculo;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DespesaController extends Controller
{
    protected Despesa $model;
    
    const VIEW_NAME = 'despesas';

    public function __construct(Despesa $despesa)
    {
        $this->model = $despesa;
    }

    /**
     * abre tela de listagem das despesas
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        if(!$request->filtro_competencia) {
            $request->offsetSet('filtro_competencia', now()->format('Ym'));
        }

        $collection = $this->model->select('despesas.*', 'veiculos.placa', 'tipo_despesas.nome as tipo_despesa')
                    ->join('veiculos', 'veiculos.id', 'despesas.veiculo_id')
                    ->join('tipo_despesas', 'tipo_despesas.id', 'despesas.tipo_despesa_id')
                    ->when($request->filtro_competencia > 0, function ($query) use ($request) {
                        return $query->where(DB::RAW("date_format(data, '%Y%m')"), $request->filtro_competencia);
                    })
                    ->when($request->filtro_placa, function ($query) use ($request) {
                        return $query->where('veiculos.placa', 'LIKE', '%' . $request->filtro_placa . '%');
                    })
                    ->orderBy('data', 'DESC')
                    ->orderBy('veiculos.placa', 'ASC')
                    ->get();
        
        $competences = $this->model->competences(12);

        return view(self::VIEW_NAME.'.index', compact('collection', 'request', 'competences'));
    }

    /**
     * abre tela de edição / cadastro da despesa
     *
     * @param Despesa $despesa
     * @return void
     */
    public function edit(Request $request, Despesa $despesa)
    {
        $tipoDespesas = TipoDespesa::orderBy('nome')->get();
        $veiculos = Veiculo::orderBy('placa')->get();

        return view(self::VIEW_NAME.'.edit',
            ['item' => $despesa, 'tipoDespesas' => $tipoDespesas, 'veiculos' => $veiculos, 'request' => $request]);
    }

    /**
     * salva os dados da despesa
     *
     * @param StoreDespesaRequest $request
     * @param Despesa $despesa
     * @return void
     */
    public function store(StoreDespesaRequest $request, Despesa $despesa)
    {
        $data = $request->only('descricao', 'tipo_despesa_id', 'veiculo_id', 'data', 'empresa');

        $data['valor'] = BaseService::convertStringToFloat($request->valor);

        $despesa->fill($data);

        if (!$despesa->save($data)) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME . '?' . $request->getQueryString())->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * exlui a despesa
     *
     * @param Despesa $despesa
     * @return void
     */
    public function destroy(Request $request, Despesa $despesa)
    {
        if (!$despesa->delete()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME . '?' . $request->getQueryString())->with('success', self::MESSAGE_SUCCESS);
    }
    
    /**
     * calcula a despesa por base em alguns parametros
     *
     * @param Request $request
     * @return void
     */
    public function calculate(Request $request)
    {
        $tipoDespesaId = $request->input('tipoDespesa');
        $veiculoId = $request->input('veiculo');
        $valorCalculado = 0;

        $tipoDespesa = TipoDespesa::find($tipoDespesaId);
        $veiculo = Veiculo::find($veiculoId);

        if ($tipoDespesa && $veiculo) {
            // quando existe um valor padrão, retorna ele
            if ($tipoDespesa->valor_padrao > '0') {
                $valorCalculado = $tipoDespesa->valor_padrao;
            }
            // para ipva, calculo especifico, total do veiculo por 12 meses
            elseif ($tipoDespesa->id === TipoDespesa::IPVA && $veiculo->ipva_total > 0) {
                $valorCalculado = $veiculo->ipva_total / 12;
            }
            // para seguro, calculo especifico, total do veiculo por 12 meses
            elseif ($tipoDespesa->id === TipoDespesa::SEGURO && $veiculo->seguro_total > 0) {
                $valorCalculado = $veiculo->seguro_total / 12;
            }
            // para salário, pega o salário do motorista
            elseif ($tipoDespesa->id === TipoDespesa::SALARIO && $veiculo->funcionario->salario > 0) {
                $valorCalculado = $veiculo->funcionario->salario;
            }            
        }

        return response()->json(['valorCalculado' => number_format($valorCalculado, 2, '.', '')]);
    }
}
