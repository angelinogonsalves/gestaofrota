<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Http\Requests\StoreFuncionarioRequest;
use App\Http\Services\BaseService;
use App\Models\Cargo;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{
    protected Funcionario $model;
    
    const VIEW_NAME = 'funcionarios';

    public function __construct(Funcionario $funcionario)
    {
        $this->model = $funcionario;
    }

    /**
     * abre tela de listagem dos funcionários
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $collection = $this->model->with(['cargo', 'veiculos'])->get();

        return view(self::VIEW_NAME.'.index', compact('collection'));
    }

    /**
     * abre tela de edição / cadastro do funcionário
     *
     * @param Funcionario $funcionario
     * @return void
     */
    public function edit(Funcionario $funcionario)
    {
        $cargos = Cargo::orderBy('nome')->get();
        
        return view(self::VIEW_NAME.'.edit', ['item' => $funcionario, 'cargos' => $cargos]);
    }

    /**
     * salva os dados do funcionário
     *
     * @param StoreFuncionarioRequest $request
     * @param Funcionario $funcionario
     * @return void
     */
    public function store(StoreFuncionarioRequest $request, Funcionario $funcionario)
    {
        $data = $request->only('nome', 'cargo_id');
        $data['salario'] = BaseService::convertStringToFloat($request->salario);

        $funcionario->fill($data);

        if (!$funcionario->save($data)) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * exlui o funcionário
     *
     * @param Funcionario $funcionario
     * @return void
     */
    public function destroy(Funcionario $funcionario)
    {
        if (!$funcionario->delete()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }
}
