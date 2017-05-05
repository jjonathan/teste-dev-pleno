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
			    'email' 	  => 'jonathan@email.com',
			    'valor_venda' => $valor_venda,
			    'comissao' 	  => ($config->comissao * $valor_venda) / 100
    		]
    	];

    	$response = $this->json('POST', '/venda/nova', $send);

    	$response
    		->assertStatus(200)
    		->assertJson($return);
    }

    // public function testIfListVendedores(){

    // 	$nome  = 'Jose da Silva';
    // 	$email = 'jose@email.com';

    //     $vendedor = [
    //         'nome'     => $nome,
    //         'email'    => $email,
    //     ];

    //     DB::table('vendedores')->insert($vendedor);

    //     $vendedores = [
    //         [
    //             'id'       => 1,
    //             'nome'     => 'Jonathan Machado',
    //             'email'    => 'jonathan@email.com',
    //         ],
    //         [
    //             'id'       => 2,
    //             'nome'     => 'Jose da Silva',
    //             'email'    => 'jose@email.com',
    //         ]
    //     ];

    //     $return = [
    //         'status'  => 'ok',
    //         'message' => 'Requisição OK',
    //         'data'    => $vendedores
    //     ];

    //     $response = $this->json('GET', '/vendedor/lista');

    // 	$response
    // 		->assertStatus(200)
    // 		->assertJson($return);
    // }
}
