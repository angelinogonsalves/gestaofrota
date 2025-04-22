<?php

namespace App\Http\Controllers;

use App\Models\TipoDespesa;
use App\Http\Requests\StoreTipoDespesaRequest;
use App\Http\Services\BaseService;
use Illuminate\Http\Request;

class TipoDespesaController extends Controller
{
    protected TipoDespesa $model;
    
    const VIEW_NAME = 'tipo-despesas';

    public function __construct(TipoDespesa $tipoDespesa)
    {
        $this->model = $tipoDespesa;
    }

    /**
     * abre tela de listagem dos tipos de despesas
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $collection = $this->model->orderBy('nome')->get();

        return view(self::VIEW_NAME.'.index', compact('collection'));
    }

    /**
     * abre tela de edição / cadastro do tipo de despesa
     *
     * @param TipoDespesa $tipoDespesa
     * @return void
     */
    public function edit(TipoDespesa $tipoDespesa)
    {
        return view(self::VIEW_NAME.'.edit', ['item' => $tipoDespesa]);
    }

    /**
     * salva os dados do tipo de despesa
     *
     * @param StoreTipoDespesaRequest $request
     * @param TipoDespesa $tipoDespesa
     * @return void
     */
    public function store(StoreTipoDespesaRequest $request, TipoDespesa $tipoDespesa)
    {
        $data = $request->only('nome', 'calculo');
        $data['valor_padrao'] = BaseService::convertStringToFloat($request->valor_padrao ?? 0);
        
        $tipoDespesa->fill($data);

        if (!$tipoDespesa->save($data)) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * exlui o tipo de despesa
     *
     * @param TipoDespesa $tipoDespesa
     * @return void
     */
    public function destroy(TipoDespesa $tipoDespesa)
    {
        if (!$tipoDespesa->delete()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }
}
