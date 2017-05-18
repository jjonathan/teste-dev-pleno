<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EmailTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testeSeEnviaEmail()
    {
    	$return = [
    		'status'  => 'ok',
    		'message' => 'E-mails enviados'
    	];

    	$response = $this->json('GET', '/email/comissao');

    	$response
    		->assertStatus(200)
    		->assertJson($return);
    }
}
