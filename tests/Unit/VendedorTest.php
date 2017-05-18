<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Vendedor;
use DB;

class VendedorTest extends TestCase{

    public function testeSeSalvaVendedor(){
    	$nome  = str_random(20);
    	$email = str_random(15) . '@gmail.com';

    	$send = [
    		'nome'  => $nome,
    		'email' => $email
    	];

    	$return = [
    		'status'  => 'ok',
    		'message' => 'Vendedor salvo!',
    		'data'    => [
    			'nome'  => $nome,
    			'email' => $email
    		]
    	];

    	$response = $this->json('POST', '/vendedor/novo', $send);

    	$response
    		->assertStatus(200)
    		->assertJson($return);
    }

    public function testeSeListaVendedores(){

    	$novoVendedor = new Vendedor([
            'nome'  => str_random(20),
            'email' => str_random(10) . '@gmail.com'
            ]);
        $novoVendedor->save();

        $vendedores    = Vendedor::all();
        $vendedoresArr = [];
        foreach ($vendedores as $key => $vendedor) {
            $vendedoresArr[] = [
                'id'    => $vendedor->id,
                'nome'  => $vendedor->nome,
                'email' => $vendedor->email
            ];
        }

        $return = [
            'status'  => 'ok',
            'message' => 'Requisição OK',
            'data'    => $vendedoresArr
        ];

        $response = $this->json('GET', '/vendedor/lista');

    	$response
    		->assertStatus(200)
    		->assertJson($return);
    }
}
