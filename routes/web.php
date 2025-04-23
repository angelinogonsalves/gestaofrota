<?php

use App\Http\Controllers\AbastecimentoController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoletoController;
use App\Http\Controllers\CaixaController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ContaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DespesaController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\FreteController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\MovimentacaoDeContaController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\OrdemDeServicoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\RelatorioEmailController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TipoDespesaController;
use App\Http\Controllers\TipoVeiculoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VeiculoController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class,'login'])->name('login');
Route::post('/loga', [AuthController::class,'loga'])->name('loga');
Route::get('/logout', [AuthController::class,'logout'])->name('logout');

// Desativa a rota de registro e recuperação de senha
// Route::get('/register', [AuthController::class,'register'])->name('register');
// Route::post('/registra', [AuthController::class,'registra'])->name('registra');
// Route::get('/recuperar-senha', [AuthController::class,'recuperarSenha'])->name('recuperar-senha');
// Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// Route::get('/resetar-senha', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

Route::get('/enviar-relatorio-movimentacoes', [RelatorioEmailController::class, 'enviarRelatorioMovimentacoes'])->name('enviar.relatorio.movimentacoes');
Route::get('/enviar-relatorio-contas-pagas', [RelatorioEmailController::class, 'enviarRelatoriocontasPagas'])->name('enviar.relatorio.contas.pagas');
Route::get('/enviar-relatorio-contas-recebidas', [RelatorioEmailController::class, 'enviarRelatoriocontasRecebidas'])->name('enviar.relatorio.contas.recebidas');


Route::middleware(['auth'])->group(function () {
      
    Route::get('/', [HomeController::class,'index'])->name('home');

    Route::get('home/', [HomeController::class,'index']);

    Route::group(array('prefix' => 'usuarios'), function(){
        Route::get('/', [UserController::class,'index']);
        // Desativa as rotas de edição, criação e exclusão de usuários:
        // Route::get('/cadastro/{user?}', [UserController::class, 'edit']);
        // Route::post('/salvar/{user?}', [UserController::class, 'store']);
        // Route::post('/excluir/{user}', [UserController::class, 'destroy']);
    });

    Route::group(array('prefix' => 'tipo-veiculos'), function(){
        Route::get('/', [TipoVeiculoController::class, 'index']);
        Route::get('/cadastro/{tipoVeiculo?}', [TipoVeiculoController::class, 'edit']);
        Route::post('/salvar/{tipoVeiculo?}', [TipoVeiculoController::class, 'store']);
        Route::post('/excluir/{tipoVeiculo}', [TipoVeiculoController::class, 'destroy']);
    });

    Route::group(array('prefix' => 'cargos'), function(){
        Route::get('/', [CargoController::class, 'index']);
        Route::get('/cadastro/{cargo?}', [CargoController::class, 'edit']);
        Route::post('/salvar/{cargo?}', [CargoController::class, 'store']);
        Route::post('/excluir/{cargo}', [CargoController::class, 'destroy']);
    });

    Route::group(array('prefix' => 'funcionarios'), function(){
        Route::get('/', [FuncionarioController::class, 'index']);
        Route::get('/cadastro/{funcionario?}', [FuncionarioController::class, 'edit']);
        Route::post('/salvar/{funcionario?}', [FuncionarioController::class, 'store']);
        Route::post('/excluir/{funcionario}', [FuncionarioController::class, 'destroy']);
    });

    Route::group(array('prefix' => 'veiculos'), function(){
        Route::get('/', [VeiculoController::class, 'index']);
        Route::get('/cadastro/{veiculo?}', [VeiculoController::class, 'edit']);
        Route::post('/salvar/{veiculo?}', [VeiculoController::class, 'store']);
        Route::post('/excluir/{veiculo}', [VeiculoController::class, 'destroy']);
    });

    Route::group(array('prefix' => 'tipo-despesas'), function(){
        Route::get('/', [TipoDespesaController::class, 'index']);
        Route::get('/cadastro/{tipoDespesa?}', [TipoDespesaController::class, 'edit']);
        Route::post('/salvar/{tipoDespesa?}', [TipoDespesaController::class, 'store']);
        Route::post('/excluir/{tipoDespesa}', [TipoDespesaController::class, 'destroy']);
    });

    Route::group(array('prefix' => 'despesas'), function(){
        Route::get('/', [DespesaController::class, 'index']);
        Route::get('/calcular', [DespesaController::class, 'calculate']);
        Route::get('/cadastro/{despesa?}', [DespesaController::class, 'edit']);
        Route::post('/salvar/{despesa?}', [DespesaController::class, 'store']);
        Route::post('/excluir/{despesa}', [DespesaController::class, 'destroy']);
    });

    Route::group(array('prefix' => 'abastecimentos'), function(){
        Route::get('/', [AbastecimentoController::class, 'index']);
        Route::get('/cadastro/{abastecimento?}', [AbastecimentoController::class, 'edit']);
        Route::post('/salvar/{abastecimento?}', [AbastecimentoController::class, 'store']);
        Route::post('/excluir/{abastecimento}', [AbastecimentoController::class, 'destroy']);
    });

    Route::group(array('prefix' => 'locais'), function(){
        Route::get('/', [LocalController::class, 'index']);
        Route::get('/cadastro/{local?}', [LocalController::class, 'edit']);
        Route::post('/salvar/{local?}', [LocalController::class, 'store']);
        Route::post('/excluir/{local}', [LocalController::class, 'destroy']);
    });

    Route::group(array('prefix' => 'fretes'), function(){
        Route::get('/', [FreteController::class, 'index'])->name('fretes');
        Route::get('/cadastro/{frete?}', [FreteController::class, 'edit']);
        Route::post('/salvar/{frete?}', [FreteController::class, 'store']);
        Route::post('/excluir/{frete}', [FreteController::class, 'destroy']);
    });

    Route::group(array('prefix' => 'ordens-de-servicos'), function(){
        Route::get('/', [OrdemDeServicoController::class, 'index']);
        Route::get('/cadastro/{ordemDeServico?}', [OrdemDeServicoController::class, 'edit']);
        Route::post('/salvar/{ordemDeServico?}', [OrdemDeServicoController::class, 'store']);
        Route::post('/excluir/{ordemDeServico}', [OrdemDeServicoController::class, 'destroy']);
    });

    Route::group(array('prefix' => 'produtos'), function(){
        Route::get('/', [ProdutoController::class, 'index']);
        Route::get('/cadastro/{produto?}', [ProdutoController::class, 'edit']);
        Route::get('/adicionar', [ProdutoController::class, 'add']);
        Route::get('/retirar', [ProdutoController::class, 'withdraw']);
        Route::get('/buscar-produtos', [ProdutoController::class, 'buscarProdutos']);
        Route::post('/salvar/{produto?}', [ProdutoController::class, 'store']);
        Route::post('/excluir/{produto}', [ProdutoController::class, 'destroy']);
    });

    Route::group(array('prefix' => 'caixas'), function(){
        Route::get('/', [CaixaController::class, 'index']);
        Route::get('/cadastro/{caixa?}', [CaixaController::class, 'edit']);
        Route::get('/adicionar/{caixa?}', [CaixaController::class, 'add']);
        Route::get('/retirar/{caixa?}', [CaixaController::class, 'withdraw']);
        Route::post('/salvar/{caixa?}', [CaixaController::class, 'store']);
        Route::post('/excluir/{caixa}', [CaixaController::class, 'destroy']);
    });

    Route::group(array('prefix' => 'relatorios'), function(){
        Route::get('/', [ReportController::class, 'index']);
        Route::get('/individual/{veiculo?}', [ReportController::class, 'show']);
    });

    Route::group(array('prefix' => 'notas'), function(){
        Route::get('/', [NotaController::class, 'index']);
        Route::get('/cadastro/{nota?}', [NotaController::class, 'edit']);
        Route::post('/salvar/{nota?}', [NotaController::class, 'store']);
        Route::post('/excluir/{nota}', [NotaController::class, 'destroy']);
        Route::post('/pagar/{nota}', [NotaController::class, 'pay']);
        Route::post('/check', [NotaController::class, 'checkNota'])->name('notas.check');
    });

    Route::group(array('prefix' => 'boletos'), function(){
        Route::get('/', [BoletoController::class, 'index']);
        Route::get('/cadastro/{boleto?}', [BoletoController::class, 'edit']);
        Route::post('/salvar/{boleto?}', [BoletoController::class, 'store']);
        Route::post('/excluir/{boleto}', [BoletoController::class, 'destroy']);
        Route::post('/pagar/{boleto}', [BoletoController::class, 'pay']);
        Route::post('/check', [BoletoController::class, 'checkBoleto'])->name('boletos.check');
    });

    /** Gestão de contas */
    Route::group(array('prefix' => 'contas'), function(){
        Route::get('/', [ContaController::class, 'index']);
        Route::get('/cadastro/{conta?}', [ContaController::class, 'edit']);
        Route::post('/salvar/{conta?}', [ContaController::class, 'store']);
        Route::post('/excluir/{conta}', [ContaController::class, 'destroy']);
    });

    Route::group(array('prefix' => 'clientes'), function(){
        Route::get('/', [ClienteController::class, 'index']);
        Route::get('/cadastro/{cliente?}', [ClienteController::class, 'edit']);
        Route::post('/salvar/{cliente?}', [ClienteController::class, 'store']);
        Route::post('/excluir/{cliente}', [ClienteController::class, 'destroy']);
    });

    Route::group(array('prefix' => 'fornecedores-funcionarios'), function(){
        Route::get('/', [FornecedorController::class, 'index']);
        Route::get('/cadastro/{fornecedor?}', [FornecedorController::class, 'edit']);
        Route::post('/salvar/{fornecedor?}', [FornecedorController::class, 'store']);
        Route::post('/excluir/{fornecedor}', [FornecedorController::class, 'destroy']);
    });

    Route::group(array('prefix' => 'movimentacoes'), function(){
        Route::get('/', [MovimentacaoDeContaController::class, 'index']);
        Route::get('/dashboard', [MovimentacaoDeContaController::class, 'dashboard']);
        Route::get('/diarias', [MovimentacaoDeContaController::class, 'diarias']);
        Route::get('/cadastro/{id?}', [MovimentacaoDeContaController::class, 'edit']);
        Route::post('/salvar/{movimentacao?}', [MovimentacaoDeContaController::class, 'store']);
        Route::post('/excluir/{movimentacao}', [MovimentacaoDeContaController::class, 'destroy']);
    });

    // API dashboards
    Route::get('/api/dados-fluxo-caixa', [DashboardController::class, 'getDadosFluxoCaixa']);
    Route::get('/api/dados-despesas-semanais', [DashboardController::class, 'getDadosDespesasSemanais']);
    Route::get('/api/dados-distribuicao-contas', [DashboardController::class, 'getDadosDistribuicaoContas']);

});
