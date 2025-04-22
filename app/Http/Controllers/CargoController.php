<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Http\Requests\StoreCargoRequest;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    protected Cargo $model;
    
    const VIEW_NAME = 'cargos';

    public function __construct(Cargo $cargo)
    {
        $this->model = $cargo;
    }

    /**
     * abre tela de listagem dos cargos
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
     * abre tela de edição / cadastro do cargo
     *
     * @param Cargo $cargo
     * @return void
     */
    public function edit(Cargo $cargo)
    {
        return view(self::VIEW_NAME.'.edit', ['item' => $cargo]);
    }

    /**
     * salva os dados do cargo
     *
     * @param StoreCargoRequest $request
     * @param Cargo $cargo
     * @return void
     */
    public function store(StoreCargoRequest $request, Cargo $cargo)
    {
        $data = $request->only('nome');
        $cargo->fill($data);

        if (!$cargo->save($data)) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * exlui o cargo
     *
     * @param Cargo $cargo
     * @return void
     */
    public function destroy(Cargo $cargo)
    {
        if (!$cargo->delete()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }
}
