<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{
    /**
     * Exibe o formulário de redefinição de senha.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.password.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
