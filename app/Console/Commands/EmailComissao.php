<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;

class EmailComissao extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:comissao';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia os e-mails com as comissões do dia';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $vendedores = \App\Models\Vendedor::all();
        foreach ($vendedores as $key => $vendedor) {
            $nome         = (string)  $vendedor->nome;
            $vendas       = \App\Models\Venda::where('vendedor_id', '=', $vendedor->id)->get();
            $email        = $vendedor->email;
            $valor_vendas = 0;
            
            foreach ($vendas as $key => $venda) {
                $valor_vendas += $venda->valor_venda;
            }

            $valor_vendas = number_format($valor_vendas, 2);

            $config   = \App\Models\Configuracao::first();
            $comissao = $config ? $config->comissao : 8.5;

            $valor_comissao = $valor_vendas > 0 ? ($comissao * $valor_vendas) / 100 : 0;

            Mail::to($email)
                ->send(new \App\Mail\ComissaoMail($nome, $valor_comissao, $vendas));
        }
    }
}
