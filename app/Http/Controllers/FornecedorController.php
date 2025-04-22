<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFornecedorRequest;
use App\Models\Fornecedor;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    protected Fornecedor $model;
    
    const VIEW_NAME = 'fornecedores-funcionarios';

    public function __construct(Fornecedor $fornecedor)
    {
        $this->model = $fornecedor;
    }

    /**
     * abre tela de listagem das Fornecedors
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
     * abre tela de edição / cadastro da Fornecedor
     *
     * @param Fornecedor $fornecedor
     * @return void
     */
    public function edit(Fornecedor $fornecedor)
    {
        return view(self::VIEW_NAME.'.edit', ['item' => $fornecedor]);
    }

    /**
     * salva os dados da Fornecedor
     *
     * @param StoreFornecedorRequest $request
     * @param Fornecedor $fornecedor
     * @return void
     */
    public function store(StoreFornecedorRequest $request, Fornecedor $fornecedor)
    {
        $data = $request->only('descricao');

        $fornecedor->fill($data);

        if (!$fornecedor->save()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * exlui a Fornecedor
     *
     * @param Fornecedor $fornecedor
     * @return void
     */
    public function destroy(Fornecedor $fornecedor)
    {
        if (!$fornecedor->delete()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }
}
