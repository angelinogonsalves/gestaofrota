<?php

namespace App\Http\Controllers;

use App\Http\Requests\CadastraUsuarioRequest;
use App\Http\Services\UsuarioService;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected User $model;
    const VIEW_NAME = 'usuarios';

    protected $redirectTo = false;

    public $usuarioService;

    public function __construct(User $user)
    {
        $this->usuarioService = new UsuarioService();
        $this->model = $user;
    }

    /**
     * mostra listagem inicial com todos os usuários
     *
     * @return void
     */
    public function index()
    {
        $collection =  $this->usuarioService->getAllUsuarios();
        return view(self::VIEW_NAME . '.index', compact('collection'));
    }

    /**
     * carrega a tela de edição / cadastro do usuário
     *
     * @param User $user
     * @return void
     */
    public function edit(User $user)
    {
        return view(self::VIEW_NAME . '.edit', ['item' => $user]);
    }

    /**
     * Salva o usuário, usa de service, nas demais controller não!
     *
     * @param CadastraUsuarioRequest $request
     * @return void
     */
    public function store(CadastraUsuarioRequest $request, User $user)
    {
        $data = $request->only('nome', 'email', 'cpf', 'tipo_usuario');

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
        
        $user->fill($data);

        if (!$user->save()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * Remove o usuário do sistema
     *
     * @param User $user
     * @return void
     */
    public function destroy(User $user)
    {
        if (!$user->delete()) {
            return $this->responseError();
        }

        return redirect(self::VIEW_NAME)->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * NÂO UTILIZADO método para retorna em tela
     *
     * @param User $user
     * @return void
     */
    public function excluirUsuario(User $user)
    {
        $returnUser = $this->usuarioService->excluiUsuario($user);

        if (!$returnUser) {
            return $this->responseError();
        }

        return $this->responseSucces();
    }
}
