<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendedor;
use App\Http\Controllers\Helpers\JsonHelper;

class VendedorController extends Controller
{

	private $request;

	public function __construct(Request $request){
		$this->request = $request;
	}

	/**
	 * Cria um novo vendedor
	 * @return json Retorna um objeto em formato json
	 */
    public function novo(){
    	$vendedor = new Vendedor();
    	$vendedorSalvo = $this->salvarVendedor($vendedor);
    	$jsonHelper = new JsonHelper();

    	if ($vendedorSalvo['data'] != null) {

    		$jsonHelper->data    = $vendedorSalvo['data'];
    		$jsonHelper->status  = 'ok';
    		$jsonHelper->message = 'Vendedor salvo!';
    	}else{

    		$jsonHelper->status  = 'error';
    		$jsonHelper->message = $vendedorSalvo['message'];
    	}

    	return response()->json($jsonHelper->toArray());
    }

    /**
     * Salva o vendedor recebido por parâmetro, utilizando a váriavel $request para pegar os dados
     * @param  Vendedor|null $vendedor Vendedor onde serão salvos os dados
     * @return array    			   Retorna um array com o Vendedor salvo e/ou a mensagem de erro caso não salve
     */
    private function salvarVendedor(Vendedor $vendedor = null){

    	$retorno            = [];
    	$retorno['data'] 	= null;
    	$retorno['message'] = null;

    	$nome  = $this->request->get('nome');
    	$email = $this->request->get('email');

        $regex_nome = "/(?=^.{2,255}$)^[A-Z][a-z]+(?:[ ][A-Z][a-z]+)*$/i";

    	if ($vendedor == null) {

    		$retorno['message'] = "Vendedor inválido";
    	} else if (!preg_match($regex_nome, $nome) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {

    		if (!preg_match($regex_nome, $nome) ) {

    			$retorno['message'] = "Nome inválido";
    		}
    		else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    			$retorno['message'] = "E-mail inválido";
    		}
    		else{

    			$retorno['message'] = "Nome e/ou E-mail inválidos";
    		}
    	} else {

            $emailInvalido = Vendedor::where('email', '=', $email)->first();
            if ($emailInvalido) {

                $retorno['message'] = "E-mail já cadastrado";
            } else {

                $vendedor->nome     = $nome;
                $vendedor->email    = $email;

                try {

                    $vendedor->save();
                    $retorno['data'] = $vendedor;
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

        $jsonHelper = new JsonHelper();

        $vendedores = Vendedor::get(['id', 'nome', 'email', 'comissao'])
            ->toArray();

        $jsonHelper->status  = "ok";
        $jsonHelper->message = "Requisição OK";
        $jsonHelper->data    = $vendedores;

        return response()->json($jsonHelper->toArray());
    }
}