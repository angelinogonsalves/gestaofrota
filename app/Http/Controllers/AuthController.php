<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Services\UsuarioService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loga(LoginRequest $request)
    {
        $validatedUser = $request->validated();
        if (Auth::attempt($validatedUser)) {
            $request->session()->regenerate();
                return redirect()->intended('/');
        }
 
        return back()->withErrors([
            'email' => 'E-mail ou senha inválidos',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
 
        $request->session()->invalidate();
        
        return redirect('/');
    }
    

    public function register()
    {
        return view('auth.register');
    }


    public function registra(RegisterRequest $request)
    {
        $validatedUser = $request->validated();

        $validatedUser['tipo_usuario'] = 1;

        $usuarioService = new UsuarioService();

        $returnUsuario = $usuarioService->salvaUser($validatedUser);

        if (!$returnUsuario) {
            return $this->responseError();
        }

        return $this->responseSucces();
    }

    public function recuperarSenha()
    {
        return view('auth.password.recuperar-senha');
    }
}
