<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContaRequest;
use App\Http\Services\BaseService;
use App\Models\Conta;
use Illuminate\Http\Request;

class ContaController extends Controller
{
    protected Conta $model;
    
    const VIEW_NAME = 'contas';

    public function __construct(Conta $conta)
    {
        $this->model = $conta;
    }

    /**
     * abre tela de listagem das contas
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $collection = $this->model->all();

        return view(self::VIEW_NAME.'.index', compact('collection'));
    }

    /**
     * abre tela de edição / cadastro da conta
     *
     * @param Conta $conta
     * @return void
     */
    public function edit(Conta $conta)
    {
        return view(self::VIEW_NAME.'.edit', ['item' => $conta]);
    }

    /**
     * salva os dados da conta
     *
     * @param StoreContaRequest $request
     * @param Conta $conta
     * @return void
     */
    public function store(StoreContaRequest $request, Conta $conta)
    {
        $data = $request->only('data_atualizacao', 'descricao');
    
        $data['saldo'] = BaseService::convertStringToFloat($request->saldo);

        $conta->fill($data);

        if (!$conta->save()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * exlui a conta
     *
     * @param Conta $conta
     * @return void
     */
    public function destroy(Conta $conta)
    {
        if (!$conta->delete()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }
}
