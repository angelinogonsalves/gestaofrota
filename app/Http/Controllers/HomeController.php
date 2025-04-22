<?php

namespace App\Http\Controllers;

use App\Models\Boleto;
use App\Models\Funcionario;
use App\Models\OrdemDeServico;
use App\Models\Produto;
use App\Models\Veiculo;

class HomeController extends Controller
{

    public function index()
    {
        $produtos = Produto::all();
        $funcionarios = Funcionario::all();
        $veiculos = Veiculo::all();
        $manutencoes = OrdemDeServico::all();

        $boletos = Boleto::where('pago', '0')->orderBy('vencimento')->get();

        return view('inicio.index', compact('produtos', 'funcionarios', 'veiculos', 'manutencoes', 'boletos'));
    }
}