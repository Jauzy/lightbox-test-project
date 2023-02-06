<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Products extends Controller
{
    public function index()
    {
        return view('products.list');
    }

    public function form($code){
        return view('products.form', ['id' => $code]);
    }

    public function new(){
        return view('products.form', ['id' => null]);
    }
}
