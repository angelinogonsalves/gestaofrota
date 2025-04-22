<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    const MESSAGE_SUCCESS = 'Ação realizada com sucesso';
    const MESSAGE_ERROR = 'Ação não pode ser realizada';

    /**
     * responseSucces
     *
     * @return view
     */
    public function responseSucces()
    {
        return redirect()->back()->with('success', self::MESSAGE_SUCCESS);
    }

    /**
     * responseError
     *
     * @return view
     */
    public function responseError()
    {
        return redirect()->back()->with('error', self::MESSAGE_ERROR);
    }
}
