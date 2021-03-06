<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Helpers\JsonHelper;
use App\Http\Controllers\Helpers\InputHelper;
use App\Models\Configuracao;
use App\Models\Vendedor;
use App\Models\Venda;

class VendaController extends Controller
{

	private $request;

	public function __construct(Request $request){
		$this->request = $request;
	}

	/**
	 * Lança uma nova venda para um vendedor
	 * @return json Retorna um objeto em formato json com a venda e o vendedor
	 */
    public function nova(){
    	$venda      = new Venda();
    	$vendaSalva = $this->salvarVenda($venda);
    	$jsonHelper = new JsonHelper();
        $jsonHelper->status  = 'error';
        $jsonHelper->message = $vendaSalva['message'];
    	if ($vendaSalva['data'] != null) {
    		$jsonHelper->data    = $vendaSalva['data'];
    		$jsonHelper->status  = 'ok';
    		$jsonHelper->message = 'Venda salva!';
    	}

    	return response()->json($jsonHelper->toArray());
    }

    /**
     * Salva a venda recebido por parâmetro, utilizando a váriavel $request para pegar os dados
     * @param  Venda|null $venda Venda onde serão salvos os dados
     * @return array    	     Retorna um array com a venda salva e/ou a mensagem de erro caso não salve
     */
    private function salvarVenda(Venda $venda = null){

    	$retorno            = [];
    	$retorno['data'] 	= null;
    	$retorno['message'] = null;

    	$vendedor_id = $this->request->get('vendedor_id');
    	$valor_venda = $this->request->get('valor_venda');

    	if ($venda == null) {
    		$retorno['message'] = "Venda inválida";
            return $retorno;
    	} 

        if (!$vendedor_id || !$valor_venda) {
            $retorno['message'] = "Vendedor e/ou valor inválidos";
            return $retorno;
        }

        $vendedor = Vendedor::find($vendedor_id);
        if (!$vendedor) {
            $retorno['message'] = "Vendedor não encontrado";
            return $retorno;
        }

        $venda->vendedor_id = (integer) $vendedor_id;
        $venda->valor_venda = (float)   $valor_venda;

        $valor_comissao = InputHelper::valorComissao($valor_venda);

        try {
            $venda->save();
            $data = [
                'id'          => $venda->id,
                'nome'        => $vendedor->nome,
                'email'       => $vendedor->email,
                'valor_venda' => (float) number_format($venda->valor_venda, 2),
                'comissao'    => (float) number_format($valor_comissao, 2)
            ];
            $retorno['data'] = $data;

        } catch (\Exception $e) {
            $retorno['message'] = "Erro ao salvar";
            $retorno['message'] = $e->getMessage(); 
        }
        return $retorno;
    }

    /**
     * Lista todos os vendedores
     * @return json Retorna um objeto em formato json, onde o atributo data são os vendedores
     */
    public function lista(){

        $jsonHelper = new JsonHelper();
        $vendedor_id = $this->request->get('vendedor_id');
        $config = Configuracao::first();

        if (!$vendedor_id) {
            
            $jsonHelper->status = 'error';
            $jsonHelper->message = 'Id do vendedor inválido';
        }else{

            $vendedor = Vendedor::find($vendedor_id);

            if (!$vendedor) {
                
                $jsonHelper->status  = 'error';
                $jsonHelper->message = 'Vendedor não encontrado';
            }else{

                $vendas = $vendedor->vendas;
                $data   = [];

                foreach ($vendas as $key => $venda) {
                    $valor_comissao = InputHelper::valorComissao($venda->valor_venda);
                    $data[] = [
                        'id'          => $venda->id,
                        'nome'        => $venda->vendedor->nome,
                        'email'       => $venda->vendedor->email,
                        'valor_venda' => (float) number_format($venda->valor_venda, 2),
                        'comissao'    => (float) number_format($valor_comissao, 2),
                        'dt_venda'    => date('Y-m-d', strtotime($venda->created_at))
                    ];
                }

                $jsonHelper->data = $data;
                $jsonHelper->status  = "ok";
                $jsonHelper->message = "Requisição OK";
            }
        }

        return response()->json($jsonHelper->toArray());
    }
}
