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
    return view('como_usar');
});

Route::get('email/comissao', 'ComissaoController@sendEmail');

Route::prefix('vendedor')->group(function(){
	Route::post('novo',  'VendedorController@novo');
	Route::get('lista',  'VendedorController@lista');
});

Route::prefix('venda')->group(function(){
	Route::post('nova', 'VendaController@nova');
	Route::get('lista', 'VendaController@lista');
});