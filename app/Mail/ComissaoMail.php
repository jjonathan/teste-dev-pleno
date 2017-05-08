<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ComissaoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Nome do vendedor
     * @var string
     */
    public $nome;

    /**
     * Valor da comissão do vendedor
     * @var float
     */
    public $valor_comissao;

    /**
     * Lista de vendas do vendedor
     * @var array
     */
    public $vendas;

    /**
     * Criar uma nova instancia de ComissaoMail
     */
    public function __construct($nome, $valor_comissao, $vendas)
    {
        $this->nome           = $nome;
        $this->valor_comissao = $valor_comissao;
        $this->vendas         = $vendas;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.comissao');
    }
}
