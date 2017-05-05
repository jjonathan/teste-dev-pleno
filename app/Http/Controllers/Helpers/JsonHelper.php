<?php

namespace App\Http\Controllers\Helpers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JsonHelper extends Controller
{
    public $data;
    public $status;
    public $message;

    public function __construct(){
    	$this->data    = null;
    	$this->status  = null;
    	$this->message = null;
    }

    public function toArray(){
    	$array = [];
    	$array['data']    = $this->data;
    	$array['status']  = $this->status;
    	$array['message'] = $this->message;
    	return $array;
    }
}
