<?php

namespace App\Http\Controllers\FE\Masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        return view('masterdata.company');
    }
}
