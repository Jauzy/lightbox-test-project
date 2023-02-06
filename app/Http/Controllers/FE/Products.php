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

    public function form($id){
        return view('products.form', ['id' => $id]);
    }

    public function new(){
        return view('products.form', ['id' => null]);
    }
}
