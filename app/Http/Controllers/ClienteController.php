<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    protected Cliente $model;
    
    const VIEW_NAME = 'clientes';

    public function __construct(Cliente $cliente)
    {
        $this->model = $cliente;
    }

    /**
     * abre tela de listagem das Clientes
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
     * abre tela de edição / cadastro da Cliente
     *
     * @param Cliente $cliente
     * @return void
     */
    public function edit(Cliente $cliente)
    {
        return view(self::VIEW_NAME.'.edit', ['item' => $cliente]);
    }

    /**
     * salva os dados da Cliente
     *
     * @param StoreClienteRequest $request
     * @param Cliente $cliente
     * @return void
     */
    public function store(StoreClienteRequest $request, Cliente $cliente)
    {
        $data = $request->only('descricao');

        $cliente->fill($data);

        if (!$cliente->save()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * exlui a Cliente
     *
     * @param Cliente $cliente
     * @return void
     */
    public function destroy(Cliente $cliente)
    {
        if (!$cliente->delete()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }
}
