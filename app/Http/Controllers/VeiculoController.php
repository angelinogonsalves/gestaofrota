<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use App\Http\Requests\StoreVeiculoRequest;
use App\Http\Services\BaseService;
use App\Models\Funcionario;
use App\Models\TipoVeiculo;
use Illuminate\Http\Request;

class VeiculoController extends Controller
{
    protected Veiculo $model;

    const VIEW_NAME = 'veiculos';

    public function __construct(Veiculo $veiculo)
    {
        $this->model = $veiculo;
    }

    /**
     * abre tela de listagem dos veículos
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $collection = $this->model->with(['tipoVeiculo', 'funcionario'])->get();

        return view(self::VIEW_NAME . '.index', compact('collection'));
    }

    /**
     * abre tela de edição / cadastro do veículo
     *
     * @param Veiculo $veiculo
     * @return void
     */
    public function edit(Veiculo $veiculo)
    {
        $motoristas = Funcionario::whereHas('cargo', function ($query) {
                                        $query->where('nome', 'LIKE', '%motorista%');
                                    })
                                    ->orderBy('nome')
                                    ->get();

        $tipoVeiculos = TipoVeiculo::orderBy('nome')->get();

        return view(
            self::VIEW_NAME . '.edit',
            ['item' => $veiculo, 'motoristas' => $motoristas, 'tipoVeiculos' => $tipoVeiculos]
        );
    }

    /**
     * salva os dados do veículo
     *
     * @param StoreVeiculoRequest $request
     * @param Veiculo $veiculo
     * @return void
     */
    public function store(StoreVeiculoRequest $request, Veiculo $veiculo)
    {
        $data = $request->only('nome', 'funcionario_id', 'placa', 'tipo_veiculo_id', 'chassi', 'ano');

        $data['km_atual'] = BaseService::convertStringToFloat($request->km_atual ?? 0);
        $data['ipva_total'] = BaseService::convertStringToFloat($request->ipva_total ?? 0);
        $data['seguro_total'] = BaseService::convertStringToFloat($request->seguro_total ?? 0);
        $data['km_prox_motor'] = BaseService::convertStringToFloat($request->km_prox_motor ?? 0);
        $data['km_prox_caixa'] = BaseService::convertStringToFloat($request->km_prox_caixa ?? 0);
        $data['km_prox_diferencial'] = BaseService::convertStringToFloat($request->km_prox_diferencial ?? 0);

        if($veiculo->km_atual != $data['km_atual']) {
            $data['km_atualizacao'] = now();
        }
        
        $veiculo->fill($data);

        if (!$veiculo->save()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * exlui o veículo
     *
     * @param Veiculo $veiculo
     * @return void
     */
    public function destroy(Veiculo $veiculo)
    {
        if (!$veiculo->delete()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }
}
