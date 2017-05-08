<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Venda;
use App\Models\Configuracao;

class VendaTest extends TestCase
{
    public function testIfVendaIsSave(){

    	Venda::truncate();

    	$vendedor_id = 1;
    	$valor_venda = 499.90;
    	$config      = Configuracao::first();

    	$send = [
    		'vendedor_id' => $vendedor_id,
    		'valor_venda' => $valor_venda
    	];

    	$return = [
    		'status'  => 'ok',
    		'message' => 'Venda salva!',
    		'data'    => [
    			'id' 		  => 1,
			    'nome' 		  => 'Jonathan Machado',
			    'email' 	  => 'jonathan.mmachado@outlook.com',
			    'valor_venda' => $valor_venda,
			    'comissao' 	  => ($config->comissao * $valor_venda) / 100
    		]
    	];

    	$response = $this->json('POST', '/venda/nova', $send);

    	$response
    		->assertStatus(200)
    		->assertJson($return);
    }

    public function testIfListVendedores(){

        $config = Configuracao::first();

        $send = [
            'vendedor_id' => 1
        ];

        $valor_venda = 499.9;
        $comissao    = $config->comissao;

        $venda = [
            [
                "id"          => 1,
                "nome"        => "Jonathan Machado",
                "email"       => "jonathan.mmachado@outlook.com",
                "valor_venda" => (float) $valor_venda,
                "comissao"    => (float) number_format(($comissao * $valor_venda) / 100, 2),
                "dt_venda"    => date('Y-m-d')
            ]
        ];

        $return = [
            'status'  => 'ok',
            'message' => 'Requisição OK',
            'data'    => $venda
        ];

        $response = $this->json('GET', '/venda/lista', $send);

    	$response
    		->assertStatus(200)
    		->assertJson($return);
    }
}
