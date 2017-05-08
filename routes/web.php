<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('vendedor')->group(function(){
	Route::post('novo',  'VendedorController@novo');
	Route::get('lista',  'VendedorController@lista');
});

Route::prefix('venda')->group(function(){
	Route::post('nova', 'VendaController@nova');
	Route::get('lista', 'VendaController@lista');
});

Route::get('/email', function(){
	$vendedores = App\Models\Vendedor::all();
    foreach ($vendedores as $key => $vendedor) {
        $nome         = (string)  $vendedor->nome;
        $vendas       = App\Models\Venda::where('vendedor_id', '=', $vendedor->id)->get();
        $email        = $vendedor->email;
        $valor_vendas = 0;
        
        foreach ($vendas as $key => $venda) {
            $valor_vendas += $venda->valor_venda;
        }

        $valor_vendas = number_format($valor_vendas, 2);

        $config   = App\Models\Configuracao::first();
        $comissao = $config ? $config->comissao : 8.5;

        $valor_comissao = $valor_vendas > 0 ? ($comissao * $valor_vendas) / 100 : 0;

        Mail::to($email)
            ->send(new App\Mail\ComissaoMail($nome, $valor_comissao, $vendas));
    }
});