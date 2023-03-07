<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Masterdata\MsCategories;
use App\Models\Masterdata\MsLumTypes;
use App\Models\Masterdata\MsBrands;

class Products extends Controller
{
    public function index()
    {
        return view('products.list');
    }

    public function form($id){
        $brands = MsBrands::all();
        $categories = MsCategories::all();
        $lumTypes = MsLumTypes::all();
        return view('products.form', ['id' => $id, 'brands' => $brands, 'categories' => $categories, 'lumtypes' => $lumTypes]);
    }

    public function new(){
        $brands = MsBrands::all();
        $categories = MsCategories::all();
        $lumTypes = MsLumTypes::all();
        return view('products.form', ['id' => null, 'brands' => $brands, 'categories' => $categories, 'lumtypes' => $lumTypes]);
    }
}
