<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $table = 'vendas';

    protected $guarded = [];

    public function vendedor(){
    	return $this->belongsTo('App\Models\Vendedor');
    }
}
