<?php

use Illuminate\Database\Seeder;

class DefaultConfig extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$config = DB::table('configuracao')->first();
    	if ($config) {
    		DB::table('configuracao')
    			->where('id', 1)
    			->update([
    				'comissao'   => 8.5,
    				'updated_at' => date('YmdHis')
    			]);
    	}else{
    		DB::table('configuracao')->insert([
	        	'comissao' => 8.5,
	        	'created_at' => date('YmdHis'),
	        	'updated_at' => date('YmdHis')
	        ]);
    	}
    }
}
