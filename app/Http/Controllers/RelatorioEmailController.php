<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\RelatorioEmail;
use App\Models\MovimentacaoDeConta;
use Illuminate\Support\Facades\Response;

class RelatorioEmailController extends Controller
{
    /**
     *  Extrato bancários conta corrente, aplicações e poupança em formato PDF
     */
    public function enviarRelatorioMovimentacoes(Request $request)
    {
        $collection = MovimentacaoDeConta::all();

        $pdf = app()->make(PDF::class);
        $pdf->loadView('movimentacoes.movimentacoesPdf', compact('collection'));
        $arquivo = public_path('relatorio_' . uniqid() . '.pdf');
        $pdf->save($arquivo);

        // $titulo = 'Relatório de movimentações';
        // $assunto = 'Extrato bancários conta corrente, aplicações e poupança';
        // $conteudo = '<p>Segue em anexo do relatório de movimentações em conta corrente, aplicações e poupança do mês corrente em PDF.</p>';

        // Mail::to('angelino.gonsalves@gmail.com')->send(new RelatorioEmail($assunto, $titulo, $conteudo, $arquivo));
        // unlink($arquivo);

        // Retornar o PDF como resposta para o navegador
        return Response::download($arquivo, 'relatorio.pdf')->deleteFileAfterSend(true);
        
        if ($request->ajax()) {
            return response()->json(['success' => 'Relatório enviado com sucesso!']);
        }
        return redirect()->back()->with('success', 'Relatório enviado com sucesso!');
    }

    /**
     * Relatório de contas pagas no mês corrente em PDF
     */
    public function enviarRelatorioContasPagas(Request $request)
    {
        $collection = MovimentacaoDeConta::all();

        $pdf = app()->make(PDF::class);
        $pdf->loadView('movimentacoes.movimentacoesPdf', compact('collection'));
        $arquivo = public_path('relatorio_' . uniqid() . '.pdf');
        $pdf->save($arquivo);

        $titulo = 'Relatório de contas pagas';
        $assunto = 'Relatório de contas pagas no mês corrente';
        $conteudo = '<p>Segue em anexo do relatório de contas pagas no mês corrente em PDF.</p>';

        Mail::to('angelino.gonsalves@gmail.com')->send(new RelatorioEmail($assunto, $titulo, $conteudo, $arquivo));
        unlink($arquivo);

        if ($request->ajax()) {
            return response()->json(['success' => 'Relatório enviado com sucesso!']);
        }
        return redirect()->back()->with('success', 'Relatório enviado com sucesso!');
    }

    /**
     * Relatório de contas recebidas no mês corrente em PDF
     */
    public function enviarRelatorioContasRecebidas(Request $request)
    {
        $collection = MovimentacaoDeConta::all();

        $pdf = app()->make(PDF::class);
        $pdf->loadView('movimentacoes.movimentacoesPdf', compact('collection'));
        $arquivo = public_path('relatorio_' . uniqid() . '.pdf');
        $pdf->save($arquivo);

        $titulo = 'Relatório de contas recebidas';
        $assunto = 'Relatório de contas recebidas no mês corrente';
        $conteudo = '<p>Segue em anexo do relatório de contas recebidas no mês corrente em PDF.</p>';

        Mail::to('angelino.gonsalves@gmail.com')->send(new RelatorioEmail($assunto, $titulo, $conteudo, $arquivo));
        unlink($arquivo);

        if ($request->ajax()) {
            return response()->json(['success' => 'Relatório enviado com sucesso!']);
        }
        return redirect()->back()->with('success', 'Relatório enviado com sucesso!');
    }
}
