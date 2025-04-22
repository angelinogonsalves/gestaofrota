<?php

namespace App\Http\Controllers;

use App\Models\TipoVeiculo;
use App\Http\Requests\StoreTipoVeiculoRequest;
use App\Http\Services\BaseService;
use App\Models\TipoDespesa;
use Illuminate\Http\Request;

class TipoVeiculoController extends Controller
{
    protected TipoVeiculo $model;
    
    const VIEW_NAME = 'tipo-veiculos';

    public function __construct(TipoVeiculo $tipoVeiculo)
    {
        $this->model = $tipoVeiculo;
    }

    /**
     * abre tela de listagem dos tipos de veículos
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $collection = $this->model->orderBy('nome')->get();

        $response = [
            'collection' => $collection,
            'prox_troca_oleo_motor' => TipoDespesa::PROX_TROCA_OLEO_MOTOR,
            'prox_troca_oleo_caixa' => TipoDespesa::PROX_TROCA_OLEO_CAIXA,
            'prox_troca_oleo_diferencial' => TipoDespesa::PROX_TROCA_OLEO_DIFERENCIAL,
        ];

        return view(self::VIEW_NAME.'.index', $response);
    }

    /**
     * abre tela de edição / cadastro do tipo de veículo
     *
     * @param TipoVeiculo $tipoVeiculo
     * @return void
     */
    public function edit(TipoVeiculo $tipoVeiculo)
    {
        $response = [
            'item' => $tipoVeiculo,
            'prox_troca_oleo_motor' => TipoDespesa::PROX_TROCA_OLEO_MOTOR,
            'prox_troca_oleo_caixa' => TipoDespesa::PROX_TROCA_OLEO_CAIXA,
            'prox_troca_oleo_diferencial' => TipoDespesa::PROX_TROCA_OLEO_DIFERENCIAL,
        ];

        return view(self::VIEW_NAME.'.edit', $response);
    }

    /**
     * salva os dados do tipo de veículo
     *
     * @param StoreTipoVeiculoRequest $request
     * @param TipoVeiculo $tipoVeiculo
     * @return void
     */
    public function store(StoreTipoVeiculoRequest $request, TipoVeiculo $tipoVeiculo)
    {
        $data = $request->only('nome', 'faz_frete', 'tipo_usuario_responsavel');
        
        $data['prox_troca_oleo_motor'] = BaseService::convertStringToFloat($request->prox_troca_oleo_motor ?? 0);
        $data['prox_troca_oleo_caixa'] = BaseService::convertStringToFloat($request->prox_troca_oleo_caixa ?? 0);
        $data['prox_troca_oleo_diferencial'] = BaseService::convertStringToFloat($request->prox_troca_oleo_diferencial ?? 0);
        
        $tipoVeiculo->fill($data);

        if (!$tipoVeiculo->save($data)) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * exclui o tipo de veículo
     *
     * @param TipoVeiculo $tipoVeiculo
     * @return void
     */
    public function destroy(TipoVeiculo $tipoVeiculo)
    {
        if (!$tipoVeiculo->delete()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }
}
