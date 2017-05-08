<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    protected $table = 'vendedores';

    protected $guarded = [];

    public function vendas(){
    	return $this->hasMany('App\Models\Venda', 'id', 'vendedor_id');
    }
}
