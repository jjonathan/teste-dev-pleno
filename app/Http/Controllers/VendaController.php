<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Helpers\JsonHelper;
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

    	if ($vendaSalva['data'] != null) {

    		$jsonHelper->data    = $vendaSalva['data'];
    		$jsonHelper->status  = 'ok';
    		$jsonHelper->message = 'Venda salva!';
    	}else{

    		$jsonHelper->status  = 'error';
    		$jsonHelper->message = $vendaSalva['message'];
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

    	$vendedor_id = (integer) $this->request->get('vendedor_id');
    	$valor_venda = (float)  $this->request->get('valor_venda');

    	if ($venda == null) {

    		$retorno['message'] = "Venda inválida";
    	} else if (!is_int($vendedor_id) || !is_float($valor_venda)) {

    		if (!is_int($vendedor_id)) {

    			$retorno['message'] = "Vendedor inválido";
    		}
    		else if (!is_float($valor_venda)) {

    			$retorno['message'] = "Valor inválido";
    		}
    		else{

    			$retorno['message'] = "Vendedor e/ou valor inválidos";
    		}
    	} else {

            $vendedor = Vendedor::find($vendedor_id);
            if (!$vendedor) {

                $retorno['message'] = "Vendedor não encontrado";
            } else {

                $venda->vendedor_id = $vendedor_id;
                $venda->valor_venda = (float) $valor_venda;

                $config = Configuracao::first();

                try {
                    $venda->save();
	                $data = [
	                	'id' => $venda->id,
	                	'nome' => $vendedor->nome,
	                	'email' => $vendedor->email,
	                	'valor_venda' => $venda->valor_venda,
	                	'comissao' => ($config->comissao * $venda->valor_venda) / 100
	                ];
	                $retorno['data'] = $data;

                } catch (\Exception $e) {
                    $retorno['message'] = "Erro ao salvar";
                    /* Caso deva mostrar o real motivo do erro, descomentar a linha abaixo */
                    /* $retorno['message'] = $e->getMessage(); */
                }
            }
        }
        return $retorno;
    }

    /**
     * Lista todos os vendedores
     * @return json Retorna um objeto em formato json, onde o atributo data são os vendedores
     */
    public function lista(){

        $vendedor_id = $this->request->get('vendedor_id');

        $jsonHelper = new JsonHelper();
        $vendas = Venda::get(['id', 'vendedor_id', 'valor_venda']);
        $data = [];

        foreach ($vendas as $key => $venda) {
            $data[] = [
                'id' => $venda->id,
                'nome' => $venda->vendedor->nome,
                'email' => $venda->vendedor->email,
                'valor_venda' => $venda->valor_venda,
                'comissao' => ($config->comissao * $venda->valor_venda) / 100,
                'dt_venda' => date('Y-m-d', strtotime($venda->created_at))
            ];
        }

        $jsonHelper->status  = "ok";
        $jsonHelper->message = "Requisição OK";
        $jsonHelper->data    = $vendas;

        return response()->json($jsonHelper->toArray());
    }
}
