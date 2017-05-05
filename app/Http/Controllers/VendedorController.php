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

    	$retorno = [];
    	$retorno['data'] 	= null;
    	$retorno['message'] = null;

    	$nome = $this->request->get('nome');
    	$email = $this->request->get('email');

    	if ($vendedor == null) {

    		$retorno['message'] = "Vendedor inválido";
    	} else if (!preg_match("/^([a-zA-Z])\w{3,}$/i", $nome) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {

    		if (!$nome) {
    			$retorno['message'] = "Nome inválido";
    		}
    		else if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
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
                $vendedor->comissao = 8.5;

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

    public function lista(){

        $vendedores = Vendedor::all()
            ->select(['id', 'nome', 'email', 'comissao']);

        print_r($vendedores);exit;

    }
}