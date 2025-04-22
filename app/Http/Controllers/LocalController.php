<?php

namespace App\Http\Controllers;

use App\Models\Local;
use App\Http\Requests\StoreLocalRequest;
use Illuminate\Http\Request;

class LocalController extends Controller
{
    protected Local $model;
    
    const VIEW_NAME = 'locais';

    public function __construct(Local $local)
    {
        $this->model = $local;
    }

    /**
     * abre tela de listagem dos locais
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
     * abre tela de edição / cadastro do local
     *
     * @param Local $local
     * @return void
     */
    public function edit(Local $local)
    {
        return view(self::VIEW_NAME.'.edit', ['item' => $local]);
    }

    /**
     * salva os dados do local
     *
     * @param StoreLocalRequest $request
     * @param Local $local
     * @return void
     */
    public function store(StoreLocalRequest $request, Local $local)
    {
        $data = $request->only('nome', 'endereco', 'cidade', 'estado');
        $local->fill($data);

        if (!$local->save($data)) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * exlui o local
     *
     * @param Local $local
     * @return void
     */
    public function destroy(Local $local)
    {
        if (!$local->delete()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }
}
