<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Vendedor;
use DB;

class VendedorTest extends TestCase{

    public function testIfVendedorIsSaved(){

    	Vendedor::truncate();

    	$nome  = 'Jonathan Machado';
    	$email = 'jonathan.mmachado@outlook.com';

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

    public function testIfListVendedores(){

    	$nome  = 'Jose da Silva';
    	$email = 'jonathan.machado4991@gmail.com';

        $vendedor = [
            'nome'     => $nome,
            'email'    => $email,
        ];

        DB::table('vendedores')->insert($vendedor);

        $vendedores = [
            [
                'id'       => 1,
                'nome'     => 'Jonathan Machado',
                'email'    => 'jonathan.mmachado@outlook.com',
            ],
            [
                'id'       => 2,
                'nome'     => 'Jose da Silva',
                'email'    => 'jonathan.machado4991@gmail.com',
            ]
        ];

        $return = [
            'status'  => 'ok',
            'message' => 'Requisição OK',
            'data'    => $vendedores
        ];

        $response = $this->json('GET', '/vendedor/lista');

    	$response
    		->assertStatus(200)
    		->assertJson($return);
    }
}
