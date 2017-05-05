<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Vendedor;

class VendedorTest extends TestCase{

    public function testIfVendedorIsSaved(){

    	Vendedor::truncate();

    	$nome  = str_random(10);
    	$email = str_random(10).'@gmail.com';

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

    // public function testIfListVendedores(){

    // 	$nome  = str_random(10);
    // 	$email = str_random(10).'@gmail.com';

    // 	$vendedor = [
    // 		'nome'     => $nome,
    // 		'email'    => $email,
    // 		'comissao' => 8.5
    // 	];

    // 	$vendedor = new Vendedor($vendedor);
    // 	$vendedor->save();

    // 	$response
    // 		->assertStatus(200)
    // 		->assertJson($return);
    // }
}
