<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Models\Vendedor;
use App\Models\Venda;
use App\Models\Configuracao;
use App\Mail\ComissaoMail;

class EnvioEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'envio:email';

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
        $vendedores = Vendedor::all();
        foreach ($vendedores as $key => $vendedor) {
            $nome        = (string)  $vendedor->nome;
            $vendas      = (array)   Venda::where('vendedor_id', '=', $vendedor->id)->get();
            $valor_venda = 0;
            
            foreach ($vendas as $key => $venda) {
                $valor_vendas += $venda->valor_venda;
            }

            $config   = Configuracao::first();
            $comissao = $config ? $config->comissao : 8.5;

            $valor_comissao = $valor_vendas > 0 ? ($comissao * $valor_vendas) / 100 : 0;
            $valor_comissao = number_format($valor_comissao, 2, ',', '.');

            Mail::to($email)
                ->send(new ComissaoMail($nome, $valor_comissao, $vendas));
        }
    }
}
