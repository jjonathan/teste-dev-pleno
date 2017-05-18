<?php

namespace App\Http\Controllers\Helpers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Configuracao;

class InputHelper extends Controller
{
    public static function randomFloat($min, $max) {
	    return ($min + lcg_value()*(abs($max - $min)));
	}

	public static function valorComissao($valor_venda){
		$config = Configuracao::first();
		$comissao = $config ? $config->comissao : 8.5;
		return $valor_venda > 0 ? ($comissao * $valor_venda) / 100 : 0;
	}
}
