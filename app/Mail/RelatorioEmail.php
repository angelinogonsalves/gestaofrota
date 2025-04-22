<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RelatorioEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $assunto;
    public $titulo;
    public $conteudo;
    public $arquivo;

    /**
     * Create a new message instance.
     *
     * @param string $relatorioPath Caminho do arquivo PDF do relatório
     * @param string $relatorioName Nome do relatório
     * @param string $viewName Nome da view do email
     * @param string $subjectText Assunto do email
     * @return void
     */
    public function __construct($assunto, $titulo, $conteudo, $arquivo)
    {
        $this->assunto = $assunto;
        $this->titulo = $titulo;
        $this->conteudo = $conteudo;
        $this->arquivo = $arquivo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.relatorio')
                    ->subject($this->assunto)
                    ->attach($this->arquivo, ['as' => 'relatorio.pdf']);
    }
}
