<?php

namespace App\Http\Controllers;

use App\Models\Frete;
use App\Http\Requests\StoreFreteRequest;
use App\Http\Services\BaseService;
use App\Models\Funcionario;
use App\Models\Local;
use App\Models\Veiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FreteController extends Controller
{
    protected Frete $model;

    const VIEW_NAME = 'fretes';

    public function __construct(Frete $frete)
    {
        $this->model = $frete;
    }

    /**
     * abre tela de listagem dos fretes
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        if(!$request->filtro_competencia) {
            $request->offsetSet('filtro_competencia', now()->format('Ym'));
        }

        $collection = $this->model->select('fretes.*',
                        'veiculos.placa',
                        'origem.nome as origem',
                        'destino.nome as destino',
                        'empresa.nome as empresa',
                        'cortador.nome as cortador',
                        'carregador.nome as carregador'
                    )
                    ->join('veiculos', 'veiculos.id', 'fretes.veiculo_id')
                    ->leftJoin('locals as origem', 'origem.id', 'fretes.local_origem_id')
                    ->leftJoin('locals as destino', 'destino.id', 'fretes.local_destino_id')
                    ->leftJoin('locals as empresa', 'empresa.id', 'fretes.local_empresa_id')
                    ->leftJoin('funcionarios as cortador', 'cortador.id', 'fretes.funcionario_cortador_id')
                    ->leftJoin('funcionarios as carregador', 'carregador.id', 'fretes.funcionario_cortador_id')
                    ->when($request->filtro_competencia > 0, function ($query) use ($request) {
                        return $query->where(DB::RAW("date_format(data_saida, '%Y%m')"), $request->filtro_competencia);
                    })
                    ->when($request->filtro_placa, function ($query) use ($request) {
                        return $query->where('veiculos.placa', 'LIKE', '%' . $request->filtro_placa . '%');
                    })
                    ->orderBy('data_saida', 'DESC')
                    ->orderBy('veiculos.placa', 'ASC')
                    ->get();
        
        $competences = $this->model->competences();

        return view(self::VIEW_NAME.'.index', compact('collection', 'request', 'competences'));
    }

    /**
     * abre tela de edição / cadastro do frete
     *
     * @param Frete $frete
     * @return void
     */
    public function edit(Request $request, Frete $frete)
    {
        $locaisOrigem = Local::orderBy('nome')->get();
        $locaisDestino = Local::orderBy('nome')->get();
        $locaisEmpresa = Local::orderBy('nome')->get();
        $veiculos = Veiculo::orderBy('placa')->get();
        $cortadores = Funcionario::orderBy('nome')->get();
        $carregadores = Funcionario::orderBy('nome')->get();

        return view(self::VIEW_NAME . '.edit', [
            'item' => $frete,
            'locaisOrigem' => $locaisOrigem,
            'locaisDestino' => $locaisDestino,
            'locaisEmpresa' => $locaisEmpresa,
            'veiculos' => $veiculos,
            'cortadores' => $cortadores,
            'carregadores' => $carregadores,
            'request' => $request
        ]);
    }

    /**
     * salva os dados do frete
     *
     * @param StoreFreteRequest $request
     * @param Frete $frete
     * @return void
     */
    public function store(StoreFreteRequest $request, Frete $frete)
    {
        $data = $request->only(
            'veiculo_id',
            'local_origem_id',
            'local_destino_id',
            'funcionario_cortador_id',
            'funcionario_carregador_id',
            'data_saida',
            'observacao',
            'espessura'
        );

        $data['valor_tonelada'] = BaseService::convertStringToFloat($request->valor_tonelada);
        $data['valor_total'] = BaseService::convertStringToFloat($request->valor_total);
        $data['peso'] = BaseService::convertStringToFloat($request->peso);
        $data['distancia'] = BaseService::convertStringToFloat($request->distancia);
        $data['comissao'] = BaseService::convertStringToFloat($request->comissao);
        $data['km_saida'] = BaseService::convertStringToFloat($request->km_saida);
        $data['km_chegada'] = BaseService::convertStringToFloat($request->km_chegada);

        /** auto atribuição a pedido do cliente */
        $data['local_empresa_id'] = $request->local_destino_id;
        $data['data_chegada'] = $request->data_saida;
        $data['data_saida'] = $request->data_saida;
        $data['data_carregamento'] = $request->data_saida;

        $frete->fill($data);

        if (!$frete->save($data)) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME . '?' . $request->getQueryString())->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * exlui o frete
     *
     * @param Frete $frete
     * @return void
     */
    public function destroy(Request $request, Frete $frete)
    {
        if (!$frete->delete()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME . '?' . $request->getQueryString())->with('success', self::MESSAGE_SUCCESS);
    }
}
