<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendedor;
use App\Models\Venda;
use App\Models\Configuracao;
use App\Mail\ComissaoMail;
use App\Http\Controllers\Helpers\InputHelper;
use Mail;

class ComissaoController extends Controller
{
    public function sendEmail(){
        $status  = 'ok';
        $message = 'E-mails enviados';
        try {
            $vendedores = Vendedor::all();
            foreach ($vendedores as $key => $vendedor) {
                $nome         = (string)  $vendedor->nome;
                $email        = $vendedor->email;
                $valor_vendas = 0;

                $vendas = Venda::where('vendedor_id', '=', $vendedor->id)
                    ->where('dt_venda', '=', date('Y-m-d'))
                    ->get();
                
                foreach ($vendas as $key => $venda) {
                    $valor_vendas += $venda->valor_venda;
                }

                $valor_vendas = number_format($valor_vendas, 2);

                $config   = Configuracao::first();
                $comissao = $config ? $config->comissao : 8.5;

                $valor_comissao = InputHelper::valorComissao($valor_vendas);

                Mail::to($email)
                    ->send(new ComissaoMail($nome, $valor_comissao, $vendas));
            }   
        } catch (\Exception $e) {
            $status  = 'error';
            $message = $e->getMessage();
        }
        return response()->json(['status' => $status, 'message' => $message]);
    }
}
