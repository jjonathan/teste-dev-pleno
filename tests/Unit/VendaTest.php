<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Venda;
use App\Models\Vendedor;
use App\Http\Controllers\Helpers\InputHelper;

class VendaTest extends TestCase
{

    public function testeSeSalvaVenda(){
        $novoVendedor = new Vendedor([
            'nome'  => str_random(20),
            'email' => str_random(10) . '@gmail.com'
            ]);
        $novoVendedor->save();
        $novoVendedor = Vendedor::orderBy('id', 'desc')->first();

    	$valor_venda    = InputHelper::randomFloat(100, 1000);
        $valor_comissao = InputHelper::valorComissao($valor_venda);
        $vendedor_id    = $novoVendedor->id;
        $vendedor_nome  = $novoVendedor->nome;
        $vendedor_email = $novoVendedor->email;

    	$send = [
    		'vendedor_id' => $vendedor_id,
    		'valor_venda' => $valor_venda
    	];

    	$return = [
            'data'    => [
                'nome'        => $vendedor_nome,
                'email'       => $vendedor_email,
                'valor_venda' => (float) number_format($valor_venda, 2),
                'comissao'    => (float) number_format($valor_comissao, 2)
            ],
    		'status'  => 'ok',
    		'message' => 'Venda salva!'
    	];

    	$response = $this->json('POST', '/venda/nova', $send);

    	$response
    		->assertStatus(200)
    		->assertJson($return);
    }

    public function testeSeListaVendas(){
        $novoVendedor = new Vendedor([
            'nome'  => str_random(20),
            'email' => str_random(10) . '@gmail.com'
            ]);
        $novoVendedor->save();
        $novoVendedor = Vendedor::orderBy('id', 'desc')->first();

        $valor_venda    = InputHelper::randomFloat(100, 1000);
        $valor_comissao = InputHelper::valorComissao($valor_venda);
        $vendedor_id    = $novoVendedor->id;
        $vendedor_nome  = $novoVendedor->nome;
        $vendedor_email = $novoVendedor->email;

        $venda = new Venda([
            'vendedor_id' => $vendedor_id,
            'valor_venda' => $valor_venda
        ]);
        $venda->save();

        $send = [
            'vendedor_id' => $vendedor_id
        ];

        $vendaArr = [
            [
                "id"          => $venda->id,
                "nome"        => $vendedor_nome,
                "email"       => $vendedor_email,
                "valor_venda" => (float) number_format($valor_venda, 2),
                "comissao"    => (float) number_format($valor_comissao, 2),
                "dt_venda"    => date('Y-m-d')
            ]
        ];

        $return = [
            'status'  => 'ok',
            'message' => 'Requisição OK',
            'data'    => $vendaArr
        ];

        $response = $this->json('GET', '/venda/lista', $send);

    	$response
    		->assertStatus(200)
    		->assertJson($return);
    }
}
