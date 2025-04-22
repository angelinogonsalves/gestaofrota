<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNotaRequest;
use App\Http\Services\BaseService;
use App\Models\Nota;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    protected Nota $model;

    const VIEW_NAME = 'notas';

    public function __construct(Nota $nota)
    {
        $this->model = $nota;
    }

    /**
     * abre tela de listagem das notas
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $collection = $this->model->get();

        return view(self::VIEW_NAME . '.index', compact('collection'));
    }

    /**
     * abre tela de edição / cadastro da Nota
     *
     * @param Nota $nota
     * @return void
     */
    public function edit(Nota $nota)
    {
        return view(self::VIEW_NAME . '.edit', ['item' => $nota]);
    }

    /**
     * salva os dados da nota
     *
     * @param StoreNotaRequest $request
     * @param Nota $nota
     * @return void
     */
    public function store(StoreNotaRequest $request, Nota $nota)
    {
        $data = $request->only('descricao', 'empresa', 'nota', 'observacao', 'emissao');

        $data['valor'] = BaseService::convertStringToFloat($request->valor ?? 0);
        $data['imposto'] = BaseService::convertStringToFloat($request->valor ?? 0);
        
        $nota->fill($data);

        if (!$nota->save()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * faz o pagamento da nota, altera seu status para pago
     *
     * @param StoreNotaRequest $request
     * @param Nota $nota
     * @return void
     */
    public function pay(StoreNotaRequest $request, Nota $nota)
    {
        $data = $request->only('pago');

        $data['pagamento'] = now();
        
        $nota->fill($data);

        if (!$nota->save()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * exlui o Nota
     *
     * @param Nota $nota
     * @return void
     */
    public function destroy(Nota $nota)
    {
        if (!$nota->delete()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * verifica se nota existe
     * 
     * @param Request $request
     * @return json $return
     */
    public function checkNota(Request $request)
    {
        $notaNumber = $request->input('nota');

        $exists = $this->model::where('nota', $notaNumber)->exists();

        return response()->json(['exists' => $exists]);
    }
}
